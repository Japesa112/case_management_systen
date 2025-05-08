<?php
namespace App\Http\Controllers;
use App\Models\CaseClosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CaseLawyer;
use App\Models\CaseModel;
use App\Models\Negotiation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;  // Import Carbon for handling timestamps
use App\Models\LawyerPayment;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseDocument;
use App\Models\Complainant;
use App\Models\CaseActivity;
use App\Models\Lawyer;
use App\Models\Payment;
use App\Mail\TestEmail;
use App\Models\Appeal;
use App\Models\Forwarding;
use App\Models\AGAdvice;
use App\Models\Adjourn;

use App\Models\TrialPreparation;
use App\Models\Trial;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Mail\NewCaseNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class MainController extends Controller {


public function getNewCasesStats()
{
    try {

        $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
            if ($isLawyer) {
                $lawyerId = Auth::user()->lawyer->lawyer_id;
                $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');
                $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // This month's new cases for the lawyer
            $thisMonth = CaseModel::whereIn('case_id', $caseIds)
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count();

            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

            // Last month's new cases for the lawyer
            $lastMonth = CaseModel::whereIn('case_id', $caseIds)
                ->whereBetween('updated_at', [$lastMonthStart, $lastMonthEnd])
                ->count();

            $change = $lastMonth > 0
                ? round((($thisMonth - $lastMonth) / $lastMonth) * 100)
                : 100;

            $trend = $change >= 0 ? "Up" : "Down";

            return response()->json([
                'count' => $thisMonth,
                'change' => abs($change),
                'trend' => $trend
            ]);
            }
            else {
                        $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();

                $thisMonth = CaseModel::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

                $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
                $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

                $lastMonth = CaseModel::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

                $change = $lastMonth > 0 
                    ? round((($thisMonth - $lastMonth) / $lastMonth) * 100)
                    : 100;

                $trend = $change >= 0 ? "Up" : "Down";

                return response()->json([
                    'count' => $thisMonth,
                    'change' => abs($change),
                    'trend' => $trend
                ]); // Get all case IDs if not a lawyer
            }
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function getUpcomingHearingsStats()
{
    try {

        $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
            if ($isLawyer) {
                $lawyerId = Auth::user()->lawyer->lawyer_id;
                $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');
                $today = Carbon::today();

            // Upcoming case activities (mentions/hearings) from today onward
            $currentCount = CaseActivity::whereIn('case_id', $caseIds)
                ->whereDate('date', '>=', $today)
                ->where(function ($query) {
                    $query->where('type', 'like', '%mention%')
                          ->orWhere('type', 'like', '%hearing%');
                })
                ->count();

            // Last month's mentions/hearings
            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

            $lastMonthCount = CaseActivity::whereIn('case_id', $caseIds)
                ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
                ->where(function ($query) {
                    $query->where('type', 'like', '%mention%')
                          ->orWhere('type', 'like', '%hearing%');
                })
                ->count();

            $change = $lastMonthCount > 0
                ? round((($currentCount - $lastMonthCount) / $lastMonthCount) * 100)
                : 100;

            $trend = $change >= 0 ? "Up" : "Down";

            return response()->json([
                'count' => $currentCount,
                'change' => abs($change),
                'trend' => $trend
            ]);
            }
            // If not a lawyer, get all upcoming case activities
            else {
                $today = Carbon::today();

        // Get count of upcoming case activities with type 'mention' or 'hearing'
        $currentCount = CaseActivity::whereDate('date', '>=', $today)
            ->where(function ($query) {
                $query->where('type', 'like', '%mention%')
                      ->orWhere('type', 'like', '%hearing%');
            })
            ->count();

        // Get count for the previous month for comparison
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $lastMonthCount = CaseActivity::whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->where(function ($query) {
                $query->where('type', 'like', '%mention%')
                      ->orWhere('type', 'like', '%hearing%');
            })
            ->count();

        $change = $lastMonthCount > 0
            ? round((($currentCount - $lastMonthCount) / $lastMonthCount) * 100)
            : 100;

        $trend = $change >= 0 ? "Up" : "Down";

        return response()->json([
            'count' => $currentCount,
            'change' => abs($change),
            'trend' => $trend
        ]);
            }

        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function getActiveCasesStats()
    {
        try {
            // Get current year and previous year
            $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
            if ($isLawyer) {
                $lawyerId = Auth::user()->lawyer->lawyer_id;
                $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');
                $currentYear = now()->year;
            $lastYear = now()->subYear()->year;

            // Filter active cases (not closed) for the assigned cases
            $active = CaseModel::whereIn('case_id', $caseIds)
                ->where('case_status', '!=', 'Closed')
                ->count();

            // Active this year
            $activeThisYear = CaseModel::whereIn('case_id', $caseIds)
                ->whereYear('created_at', $currentYear)
                ->where('case_status', '!=', 'Closed')
                ->count();

            // Active last year
            $activeLastYear = CaseModel::whereIn('case_id', $caseIds)
                ->whereYear('created_at', $lastYear)
                ->where('case_status', '!=', 'Closed')
                ->count();

            // Calculate percentage difference
            if ($activeLastYear > 0) {
                $percentChange = round((($activeThisYear - $activeLastYear) / $activeLastYear) * 100);
            } else {
                $percentChange = 100; // Assume 100% if no cases last year
            }

            $trend = $percentChange >= 0
                ? "Up from last year ({$percentChange}%)"
                : "Down from last year (" . abs($percentChange) . "%)";

            return response()->json([
                'count' => $active,
                'trend' => $trend
            ]);

            } else {
                
                
            $currentYear = now()->year;
            $lastYear = now()->subYear()->year;
    

            $active = CaseModel::where('case_status', '!=', 'Closed')
                ->count();
            // Get counts of active cases (not 'Closed') for both years
            $activeThisYear = CaseModel::whereYear('created_at', $currentYear)
                ->where('case_status', '!=', 'Closed')
                ->count();
    
            $activeLastYear = CaseModel::whereYear('created_at', $lastYear)
                ->where('case_status', '!=', 'Closed')
                ->count();
    
            // Calculate percentage difference
            if ($activeLastYear > 0) {
                $percentChange = round((($activeThisYear - $activeLastYear) / $activeLastYear) * 100);
            } else {
                $percentChange = 100; // Assume 100% if no cases last year
            }
    
            $trend = $percentChange >= 0
                ? "Up from last year ({$percentChange}%)"
                : "Down from last year (" . abs($percentChange) . "%)";
    
            return response()->json([
                'count' => $active,
                'trend' => $trend
            ]);

            }
            
        } catch (\Exception $e) {
            Log::error("Error retrieving active case stats: " . $e->getMessage());
    
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getUpcomingDates()
{
    try {
        $now = Carbon::now();
        $upcoming = collect();

        // Add Negotiations
        $upcoming = $upcoming->merge(
            Negotiation::all()
                ->filter(fn($n) => Carbon::parse($n->initiation_datetime)->isFuture())
                ->map(fn($n) => [
                    'type' => 'Negotiation',
                    'description' => $n->subject,
                    'datetime' => Carbon::parse($n->initiation_datetime)->toDateTimeString(),
                    'badge_color' => 'rgb(6, 53, 80)'
                ])
        );

        // Add Lawyer Payments
        $upcoming = $upcoming->merge(
            LawyerPayment::all()
                ->filter(fn($p) => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Lawyer Payment',
                    'description' => $p->transaction,
                    'datetime' => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->toDateTimeString(),
                    'badge_color' => 'rgb(14, 168, 22)'
                ])
        );

        $upcoming = $upcoming->merge(
            Payment::all()
                ->filter(fn($p) => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Payment',
                    'description' => $p->transaction,
                    'datetime' => Carbon::parse($p->payment_date . ' ' . $p->payment_time)->toDateTimeString(),
                    'badge_color' => 'rgb(194, 15, 218)'
                ])
        );

        $upcoming = $upcoming->merge(
            AGAdvice::all()
                ->filter(fn($p) => Carbon::parse($p->advice_date . ' ' . $p->advice_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'AG Advice',
                    'description' => $p->ag_advice,
                    'datetime' => Carbon::parse($p->advice_date . ' ' . $p->advice_time)->toDateTimeString(),
                    'badge_color' => '#272838'
                ])
        );

        $upcoming = $upcoming->merge(
            Forwarding::all()
                ->filter(fn($p) => Carbon::parse($p->dvc_appointment_date . ' ' . $p->dvc_appointment_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'DVC Forwarding',
                    'description' => $p->briefing_notes,
                    'datetime' => Carbon::parse($p->dvc_appointment_date . ' ' . $p->dvc_appointment_time)->toDateTimeString(),
                    'badge_color' => '#F2B418'
                ])
        );

        $upcoming = $upcoming->merge(
            Trial::all()
                ->filter(fn($p) => Carbon::parse($p->trial_date . ' ' . $p->trial_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Trial',
                    'description' => $p->judgement_details,
                    'datetime' => Carbon::parse($p->trial_date . ' ' . $p->trial_time)->toDateTimeString(),
                    'badge_color' => '#F2B418'
                ])
        );

         $upcoming = $upcoming->merge(
            TrialPreparation::all()
                ->filter(fn($p) => Carbon::parse($p->preparation_date . ' ' . $p->preparation_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Preparation',
                    'description' => $p->briefing_notes,
                    'datetime' => Carbon::parse($p->preparation_date . ' ' . $p->preparation_time)->toDateTimeString(),
                    'badge_color' => '#445D48'
                ])
        );

        $upcoming = $upcoming->merge(
            Adjourn::all()
                ->filter(fn($p) => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Adjourn',
                    'description' => $p->adjourn_comments,
                    'datetime' => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->toDateTimeString(),
                    'badge_color' => '#F57251'
                ])
        );

        $upcoming = $upcoming->merge(
            Appeal::all()
                ->filter(fn($p) => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Appeal',
                    'description' => $p->appeal_comments,
                    'datetime' => Carbon::parse($p->next_hearing_date . ' ' . $p->next_hearing_time)->toDateTimeString(),
                    'badge_color' => '#C4AD9D'
                ])
        );

        $upcoming = $upcoming->merge(
            CaseActivity::all()
                ->filter(fn($p) => Carbon::parse($p->date->format('Y-m-d'). ' ' . $p->time)->isFuture())
                ->map(fn($p) => [
                    'type' => 'Court Session',
                    'description' => $p->type,
                    'datetime' => Carbon::parse($p->date->format('Y-m-d') . ' ' . $p->time)->toDateTimeString(),
                    'badge_color' => '#C4AD9D'
                ])
        );


        // Sort and take only the first 10
        $upcoming = $upcoming->sortBy('datetime')->take(10)->values();

        return response()->json($upcoming);
    } catch (\Exception $e) {
        Log::error('Failed to get upcoming dates: ' . $e->getMessage());
        return response()->json(['error' => 'Could not fetch upcoming dates'], 500);
    }
}


    public function getCasesByStatus($status)
{
    Log::info("Fetching cases with status: $status");

    try {
        $cases = CaseModel::where('case_status', $status)
            ->select('case_name') // or other relevant fields
            ->get()
            ->pluck('case_name');

        Log::info("Successfully retrieved cases for status: $status");

        return response()->json($cases);
    } catch (\Exception $e) {
        Log::error("Error retrieving cases: " . $e->getMessage());
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function getAllLawyerCaseDistribution()
    {
        try {
            $lawyerStats = CaseLawyer::with('lawyer.user')
                ->select('lawyer_id', DB::raw('COUNT(*) as total_cases'))
                ->groupBy('lawyer_id')
                ->orderByDesc('total_cases')
                ->get()
                ->map(function ($entry) {
                    return [
                        'full_name' => optional($entry->lawyer->user)->full_name ?? 'Unknown',
                        'total_cases' => $entry->total_cases,
                        'lawyer_id' => $entry->lawyer->lawyer_id
                    ];
                });
    
            return response()->json($lawyerStats);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function getCasesByLawyer($lawyerId)
{
   Log::info("I am in getCases");
    try{
    $cases = CaseLawyer::where('lawyer_id', $lawyerId)
        ->with('case')  // Assuming CaseLawyer has a relationship with Case model
        ->get()
        ->pluck('case.case_name'); // Adjust according to your case model field name
        Log::info('Colected successfully for the lawyer'. $lawyerId .'');
    return response()->json($cases);
    }
    catch(\Exception $e){
        Log::error($e->getMessage());
        return response()->json([
            'error'=> $e->getMessage()
            ], 500);
        }
}

public function getLawyerCaseDistribution(Request $request)
{
    try {
        $lawyerStats = CaseLawyer::with('lawyer.user')
            ->select('lawyer_id', DB::raw('COUNT(*) as total_cases'))
            ->groupBy('lawyer_id')
            ->orderByDesc('total_cases')
            ->take(15) // <-- LIMIT to top 15
            ->get()
            ->map(function ($entry) {
                return [
                    'full_name' => optional($entry->lawyer->user)->full_name ?? 'Unknown',
                    'total_cases' => $entry->total_cases,
                    'lawyer_id' => $entry->lawyer->lawyer_id
                ];
            });

        Log::info('Collected Successfully: ' . json_encode($lawyerStats));

        return response()->json($lawyerStats);
    } catch (\Exception $e) {
        Log::error('Error while retrieving data from Case Lawyer: ' . $e->getMessage());
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
}



    public function getCaseStatusData()
{
    $data = DB::table('cases')
        ->select('case_status', DB::raw('count(*) as total'))
        ->groupBy('case_status')
        ->orderBy('total', 'desc') // optional: order by count
        ->get();

    return response()->json($data);
}
    public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function dashboardV1() {
        return view('pages/dashboard-v1');
    }
    public function home() {
        return view('pages/home');
    }
    public function dashboardV2() {
        $wonCases = CaseClosure::where('final_outcome', 'Win')->count();
        $lostCases = CaseClosure::where('final_outcome', 'Loss')->count();
        $closedCases = $wonCases + $lostCases;
    
        return view('pages/dashboard-v2', [
            'wonCases' => $wonCases,
            'lostCases' => $lostCases,
            'closedCases' => $closedCases,
        ]);
    }
    public function dashboardV3() {
        return view('pages/dashboard-v3');
    }
    
    public function emailInbox() {
        return view('pages/email-inbox');
    }
    public function emailCompose() {
        return view('pages/email-compose');
    }
    public function emailDetail() {
        return view('pages/email-detail');
    }
    
    public function widget() {
        return view('pages/widget');
    }
    
    public function uiGeneral() {
        return view('pages/ui-general');
    }
    public function uiTypography() {
        return view('pages/ui-typography');
    }
    public function uiTabsAccordions() {
        return view('pages/ui-tabs-accordions');
    }
    public function uiUnlimitedNavTabs() {
        return view('pages/ui-unlimited-nav-tabs');
    }
    public function uiModalNotification() {
        return view('pages/ui-modal-notification');
    }
    public function uiWidgetBoxes() {
        return view('pages/ui-widget-boxes');
    }
    public function uiMediaObject() {
        return view('pages/ui-media-object');
    }
    public function uiButtons() {
        return view('pages/ui-buttons');
    }
    public function uiIconFontAwesome() {
        return view('pages/ui-icon-fontawesome');
    }
    public function uiIconBootstrapIcons() {
        return view('pages/ui-icon-bootstrap-icons');
    }
    public function uiIconDuotone() {
        return view('pages/ui-icon-duotone');
    }
    public function uiIconSimpleLineIcons() {
        return view('pages/ui-icon-simple-line-icons');
    }
    public function uiIconIonicons() {
        return view('pages/ui-icon-ionicons');
    }
    public function uiTreeView() {
        return view('pages/ui-tree-view');
    }
    public function uiLanguageBarIcon() {
        return view('pages/ui-language-bar-icon');
    }
    public function uiSocialButtons() {
        return view('pages/ui-social-buttons');
    }
    public function uiIntroJs() {
        return view('pages/ui-intro-js');
    }
    public function uiOffcanvasToasts() {
        return view('pages/ui-offcanvas-toasts');
    }
    
    public function bootstrap5() {
        return view('pages/bootstrap-5');
    }
    
    public function formElements() {
        return view('pages/form-elements');
    }
    public function formPlugins() {
        return view('pages/form-plugins');
    }
    public function formSliderSwitcher() {
        return view('pages/form-slider-switcher');
    }
    public function formValidation() {
        return view('pages/form-validation');
    }
    public function formWizards() {
        return view('pages/form-wizards');
    }
    public function formWysiwyg() {
        return view('pages/form-wysiwyg');
    }
    public function formXEditable() {
        return view('pages/form-x-editable');
    }
    public function formMultipleFileUpload() {
        return view('pages/form-multiple-file-upload');
    }
    public function formSummernote() {
        return view('pages/form-summernote');
    }
    public function formDropzone() {
        return view('pages/form-dropzone');
    }
    
    public function tableBasic() {
        return view('pages/table-basic');
    }
    public function tableManageDefault() {
        return view('pages/table-manage-default');
    }
    public function tableManageButtons() {
        return view('pages/table-manage-buttons');
    }
    public function tableManageColreorder() {
        return view('pages/table-manage-colreorder');
    }
    public function tableManageFixedColumn() {
        return view('pages/table-manage-fixed-column');
    }
    public function tableManageFixedHeader() {
        return view('pages/table-manage-fixed-header');
    }
    public function tableManageKeytable() {
        return view('pages/table-manage-keytable');
    }
    public function tableManageResponsive() {
        return view('pages/table-manage-responsive');
    }
    public function tableManageRowreorder() {
        return view('pages/table-manage-rowreorder');
    }
    public function tableManageScroller() {
        return view('pages/table-manage-scroller');
    }
    public function tableManageSelect() {
        return view('pages/table-manage-select');
    }
    public function tableManageCombine() {
        return view('pages/table-manage-combine');
    }
    
    public function posCustomerOrder() {
        return view('pages/pos-customer-order');
    }
    public function posKitchenOrder() {
        return view('pages/pos-kitchen-order');
    }
    public function posCounterCheckout() {
        return view('pages/pos-counter-checkout');
    }
    public function posTableBooking() {
        return view('pages/pos-table-booking');
    }
    public function posMenuStock() {
        return view('pages/pos-menu-stock');
    }
    
    public function emailTemplateSystem() {
        return view('pages/email-template-system');
    }
    public function emailTemplateNewsletter() {
        return view('pages/email-template-newsletter');
    }
    
    public function chartFlot() {
        return view('pages/chart-flot');
    }
    public function chartJs() {
        return view('pages/chart-js');
    }
    public function chartD3() {
        return view('pages/chart-d3');
    }
    public function chartApex() {
        return view('pages/chart-apex');
    }
    
    public function landing() {
        return view('pages/landing');
    }
    
    public function calendar() {
        return view('pages/calendar');
    }
    
    public function mapVector() {
        return view('pages/map-vector');
    }
    public function mapGoogle() {
        return view('pages/map-google');
    }
    
    public function galleryV1() {
        return view('pages/gallery-v1');
    }
    public function galleryV2() {
        return view('pages/gallery-v2');
    }
    
    public function pageBlank() {
        return view('pages/page-blank');
    }
    public function pageWithFooter() {
        return view('pages/page-with-footer');
    }
    public function pageWithFixedFooter() {
        return view('pages/page-with-fixed-footer');
    }
    public function pageWithoutSidebar() {
        return view('pages/page-without-sidebar');
    }
    public function pageWithRightSidebar() {
        return view('pages/page-with-right-sidebar');
    }
    public function pageWithMinifiedSidebar() {
        return view('pages/page-with-minified-sidebar');
    }
    public function pageWithTwoSidebar() {
        return view('pages/page-with-two-sidebar');
    }
    public function pageFullHeight() {
        return view('pages/page-full-height');
    }
    public function pageWithWideSidebar() {
        return view('pages/page-with-wide-sidebar');
    }
    public function pageWithLightSidebar() {
        return view('pages/page-with-light-sidebar');
    }
    public function pageWithMegaMenu() {
        return view('pages/page-with-mega-menu');
    }
    public function pageWithTopMenu() {
        return view('pages/page-with-top-menu');
    }
    public function pageWithBoxedLayout() {
        return view('pages/page-with-boxed-layout');
    }
    public function pageWithMixedMenu() {
        return view('pages/page-with-mixed-menu');
    }
    public function boxedLayoutWithMixedMenu() {
        return view('pages/page-boxed-layout-with-mixed-menu');
    }
    public function pageWithTransparentSidebar() {
        return view('pages/page-with-transparent-sidebar');
    }
    public function pageWithSearchSidebar() {
        return view('pages/page-with-search-sidebar');
    }
    public function pageWithHoverSidebar() {
        return view('pages/page-with-hover-sidebar');
    }
    
    public function extraTimeline() {
        return view('pages/extra-timeline');
    }
    public function extraComingSoon() {
        return view('pages/extra-coming-soon');
    }
    public function extraSearchResult() {
        return view('pages/extra-search-result');
    }
    public function extraInvoice() {
        return view('pages/extra-invoice');
    }
    public function extraErrorPage() {
        return view('pages/extra-error-page');
    }
    public function extraProfile() {
        return view('pages/extra-profile');
    }
    public function extraScrumBoard() {
        return view('pages/extra-scrum-board');
    }
    public function extraCookieAcceptanceBanner() {
        return view('pages/extra-cookie-acceptance-banner');
    }
    public function extraOrders() {
        return view('pages/extra-orders');
    }
    public function extraOrderDetails() {
        return view('pages/extra-order-details');
    }
    public function extraProducts() {
        return view('pages/extra-products');
    }
    public function extraProductDetails() {
        return view('pages/extra-product-details');
    }
    public function extraFileManager() {
        return view('pages/extra-file-manager');
    }
    public function extraPricingPage() {
        return view('pages/extra-pricing-page');
    }
    public function extraMessengerPage() {
        return view('pages/extra-messenger-page');
    }
    public function extraDataManagement() {
        return view('pages/extra-data-management');
    }
    public function extraSettingsPage() {
        return view('pages/extra-settings-page');
    }
    
    public function loginV1() {
        return view('pages/login-v1');
    }
    public function loginV2() {
        return view('pages/login-v2');
    }
    public function loginV3() {
        return view('pages/login-v3');
    }
    public function registerV3() {
        return view('pages/register-v3');
    }
    
    public function helperCss() {
        return view('pages/helper-css');
    }
}