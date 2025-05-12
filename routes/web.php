<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\PanelEvaluation;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\CaseDocumentsController;
use App\Http\Controllers\ComplainantsController;
use App\Http\Controllers\NegotiationController;
use App\Http\Controllers\NegotiationAttachmentController;
use App\Http\Controllers\PanelEvaluationController;
use App\Http\Controllers\AdjournController;
use App\Http\Controllers\WitnessController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\TrialPreparationController;
use App\Http\Controllers\MainController;

use App\Http\Controllers\LawyerPaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CaseClosureController;
use \App\Http\Controllers\ForwardingController;
use \App\Http\Controllers\DvcAppointmentController;
;
use App\Http\Controllers\AGAdviceController;
use Illuminate\Support\Facades\Log;



use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;



Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login/v2');
    }
    
    Log::info("The user role is: ".Auth::user()->role);
    // Check user role and redirect accordingly
    if (Auth::user()->role === 'Lawyer') {
        return redirect('/dashboard/lawyer');
    }




    return redirect('/dashboard/v2'); // Default for other roles
});

Route::post('/login', [LoginController::class, 'login'])->name('login.post');   // Process login

Route::get('/dashboard/lawyer', [LawyerController::class, 'dashboard'])->name('dashboard-v2-lawyer');


Route::get('/dashboard/v1', 'MainController@dashboardV1')->name('dashboard-v1');
Route::get('/dashboard/v2', 'MainController@dashboardV2')->name('dashboard-v2');
Route::get('/dashboard/v3', 'MainController@dashboardV3')->name('dashboard-v3');

Route::get('/case-status-data', [MainController::class, 'getCaseStatusData']);
Route::get('/lawyer-case-distribution', [MainController::class, 'getLawyerCaseDistribution'])
     ->name('lawyer.case.distribution');
Route::get('/cases-by-lawyer/{lawyerId}', [MainController::class, 'getCasesByLawyer'])->name('cases.by.lawyer');
Route::get('/lawyers/case-distribution/all', [MainController::class, 'getAllLawyerCaseDistribution'])->name('lawyer.case.distribution.all');
Route::get('/dashboard/upcoming-dates', [MainController::class, 'getUpcomingDates'])->name('dashboard.upcoming-dates');

Route::get('/cases/by-status/{status}', [MainController::class, 'getCasesByStatus'])->name('cases.by.status');
Route::get('/stats/active-cases', [MainController::class, 'getActiveCasesStats'])->name('stats.active.cases');
Route::get('/stats/upcoming-hearings', [MainController::class, 'getUpcomingHearingsStats'])->name('stats.upcoming.hearings');
Route::get('/stats/new-cases', [MainController::class, 'getNewCasesStats'])->name('stats.new.cases');
Route::get('/lawyer/compliance-stats', [LawyerController::class, 'getComplianceStats'])->name('lawyer.compliance.stats');
Route::get('/lawyer/cases-awaiting-actions', [LawyerController::class, 'getCasesAwaitingAction'])
    ->name('lawyer.cases.awaiting.actions');


Route::get('/email/inbox', 'MainController@emailInbox')->name('email-inbox');
Route::get('/email/compose', 'MainController@emailCompose')->name('email-compose');
Route::get('/email/detail', 'MainController@emailDetail')->name('email-detail');

Route::get('/widget', 'MainController@widget')->name('widget');

Route::get('/ui/general', 'MainController@uiGeneral')->name('ui-general');
Route::get('/ui/typography', 'MainController@uiTypography')->name('ui-typography');
Route::get('/ui/tabs-accordions', 'MainController@uiTabsAccordions')->name('ui-tabs-accordions');
Route::get('/ui/unlimited-nav-tabs', 'MainController@uiUnlimitedNavTabs')->name('ui-unlimited-nav-tabs');
Route::get('/ui/modal-notification', 'MainController@uiModalNotification')->name('ui-modal-notification');
Route::get('/ui/widget-boxes', 'MainController@uiWidgetBoxes')->name('ui-widget-boxes');
Route::get('/ui/media-object', 'MainController@uiMediaObject')->name('ui-media-object');
Route::get('/ui/buttons', 'MainController@uiButtons')->name('ui-buttons');
Route::get('/ui/icon-fontawesome', 'MainController@uiIconFontAwesome')->name('ui-icon-fontawesome');
Route::get('/ui/icon-bootstrap-icons', 'MainController@uiIconBootstrapIcons')->name('ui-icon-bootstrap-icons');
Route::get('/ui/icon-duotone', 'MainController@uiIconDuotone')->name('ui-icon-duotone');
Route::get('/ui/icon-simple-line-icons', 'MainController@uiIconSimpleLineIcons')->name('ui-icon-simple-line-icons');
Route::get('/ui/icon-ionicons', 'MainController@uiIconIonicons')->name('ui-icon-ionicons');
Route::get('/ui/tree-view', 'MainController@uiTreeView')->name('ui-tree-view');
Route::get('/ui/language-bar-icon', 'MainController@uiLanguageBarIcon')->name('ui-language-bar-icon');
Route::get('/ui/social-buttons', 'MainController@uiSocialButtons')->name('ui-social-buttons');
Route::get('/ui/intro-js', 'MainController@uiIntroJs')->name('ui-intro-js');
Route::get('/ui/offcanvas-toasts', 'MainController@uiOffcanvasToasts')->name('ui-offcanvas-toasts');

Route::get('/bootstrap-5', 'MainController@bootstrap5')->name('bootstrap-5');

Route::get('/form/elements', 'MainController@formElements')->name('form-elements');
Route::get('/form/plugins', 'MainController@formPlugins')->name('form-plugins');
Route::get('/form/slider-switcher', 'MainController@formSliderSwitcher')->name('form-slider-switcher');
Route::get('/form/validation', 'MainController@formValidation')->name('form-validation');
Route::get('/form/wizards', 'MainController@formWizards')->name('form-wizards');
Route::get('/form/wysiwyg', 'MainController@formWysiwyg')->name('form-wysiwyg');
Route::get('/form/x-editable', 'MainController@formXEditable')->name('form-x-editable');
Route::get('/form/multiple-file-upload', 'MainController@formMultipleFileUpload')->name('form-multiple-file-upload');
Route::get('/form/summernote', 'MainController@formSummernote')->name('form-summernote');
Route::get('/form/dropzone', 'MainController@formDropzone')->name('form-dropzone');

Route::get('/table/basic', 'MainController@tableBasic')->name('table-basic');
Route::get('/table/manage/default', 'MainController@tableManageDefault')->name('table-manage-default');
Route::get('/table/manage/buttons', 'MainController@tableManageButtons')->name('table-manage-buttons');
Route::get('/table/manage/colreorder', 'MainController@tableManageColreorder')->name('table-manage-colreorder');
Route::get('/table/manage/fixed-column', 'MainController@tableManageFixedColumn')->name('table-manage-fixed-column');
Route::get('/table/manage/fixed-header', 'MainController@tableManageFixedHeader')->name('table-manage-fixed-header');
Route::get('/table/manage/keytable', 'MainController@tableManageKeytable')->name('table-manage-keytable');
Route::get('/table/manage/responsive', 'MainController@tableManageResponsive')->name('table-manage-responsive');
Route::get('/table/manage/rowreorder', 'MainController@tableManageRowreorder')->name('table-manage-rowreorder');
Route::get('/table/manage/scroller', 'MainController@tableManageScroller')->name('table-manage-scroller');
Route::get('/table/manage/select', 'MainController@tableManageSelect')->name('table-manage-select');
Route::get('/table/manage/combine', 'MainController@tableManageCombine')->name('table-manage-combine');

Route::get('/pos/customer-order', 'MainController@posCustomerOrder')->name('pos-customer-order');
Route::get('/pos/kitchen-order', 'MainController@posKitchenOrder')->name('pos-kitchen-order');
Route::get('/pos/counter-checkout', 'MainController@posCounterCheckout')->name('pos-counter-checkout');
Route::get('/pos/table-booking', 'MainController@posTableBooking')->name('pos-table-booking');
Route::get('/pos/menu-stock', 'MainController@posMenuStock')->name('pos-menu-stock');

Route::get('/email-template/system', 'MainController@emailTemplateSystem')->name('email-template-system');
Route::get('/email-template/newsletter', 'MainController@emailTemplateNewsletter')->name('email-template-newsletter');

Route::get('/chart/flot', 'MainController@chartFlot')->name('chart-flot');
Route::get('/chart/js', 'MainController@chartJs')->name('chart-js');
Route::get('/chart/d3', 'MainController@chartD3')->name('chart-d3');
Route::get('/chart/apex', 'MainController@chartApex')->name('chart-apex');

Route::get('/landing', 'MainController@landing')->name('landing');

Route::get('/calendar', 'MainController@calendar')->name('calendar');

Route::get('/map/vector', 'MainController@mapVector')->name('map-vector');
Route::get('/map/google', 'MainController@mapGoogle')->name('map-google');

Route::get('/gallery/v1', 'MainController@galleryV1')->name('gallery-v1');
Route::get('/gallery/v2', 'MainController@galleryV2')->name('gallery-v2');

Route::get('/page-option/page-blank', 'MainController@pageBlank')->name('page-blank');
Route::get('/page-option/page-with-footer', 'MainController@pageWithFooter')->name('page-with-footer');
Route::get('/page-option/page-with-fixed-footer', 'MainController@pageWithFixedFooter')->name('page-with-fixed-footer');
Route::get('/page-option/page-without-sidebar', 'MainController@pageWithoutSidebar')->name('page-without-sidebar');
Route::get('/page-option/page-with-right-sidebar', 'MainController@pageWithRightSidebar')->name('page-with-right-sidebar');
Route::get('/page-option/page-with-minified-sidebar', 'MainController@pageWithMinifiedSidebar')->name('page-with-minified-sidebar');
Route::get('/page-option/page-with-two-sidebar', 'MainController@pageWithTwoSidebar')->name('page-with-two-sidebar');
Route::get('/page-option/page-full-height', 'MainController@pageFullHeight')->name('page-full-height');
Route::get('/page-option/page-with-wide-sidebar', 'MainController@pageWithWideSidebar')->name('page-with-wide-sidebar');
Route::get('/page-option/page-with-light-sidebar', 'MainController@pageWithLightSidebar')->name('page-with-light-sidebar');
Route::get('/page-option/page-with-mega-menu', 'MainController@pageWithMegaMenu')->name('page-with-mega-menu');
Route::get('/page-option/page-with-top-menu', 'MainController@pageWithTopMenu')->name('page-with-top-menu');
Route::get('/page-option/page-with-boxed-layout', 'MainController@pageWithBoxedLayout')->name('page-with-boxed-layout');
Route::get('/page-option/page-with-mixed-menu', 'MainController@pageWithMixedMenu')->name('page-with-mixed-menu');
Route::get('/page-option/boxed-layout-with-mixed-menu', 'MainController@boxedLayoutWithMixedMenu')->name('boxed-layout-with-mixed-menu');
Route::get('/page-option/page-with-transparent-sidebar', 'MainController@pageWithTransparentSidebar')->name('page-with-transparent-sidebar');
Route::get('/page-option/page-with-search-sidebar', 'MainController@pageWithSearchSidebar')->name('page-with-search-sidebar');
Route::get('/page-option/page-with-hover-sidebar', 'MainController@pageWithHoverSidebar')->name('page-with-hover-sidebar');

Route::get('/extra/timeline', 'MainController@extraTimeline')->name('extra-timeline');
Route::get('/extra/coming-soon', 'MainController@extraComingSoon')->name('extra-coming-soon');
Route::get('/extra/search-result', 'MainController@extraSearchResult')->name('extra-search-result');
Route::get('/extra/invoice', 'MainController@extraInvoice')->name('extra-invoice');
Route::get('/extra/error-page', 'MainController@extraErrorPage')->name('extra-error-page');
Route::get('/extra/profile', 'MainController@extraProfile')->name('extra-profile');
Route::get('/extra/scrum-board', 'MainController@extraScrumBoard')->name('extra-scrum-board');
Route::get('/extra/cookie-acceptance-banner', 'MainController@extraCookieAcceptanceBanner')->name('extra-cookie-acceptance-banner');
Route::get('/extra/orders', 'MainController@extraOrders')->name('extra-orders');
Route::get('/extra/order-details', 'MainController@extraOrderDetails')->name('extra-order-details');
Route::get('/extra/products', 'MainController@extraProducts')->name('extra-products');
Route::get('/extra/product-details', 'MainController@extraProductDetails')->name('extra-product-details');
Route::get('/extra/file-manager', 'MainController@extraFileManager')->name('extra-file-manager');
Route::get('/extra/pricing-page', 'MainController@extraPricingPage')->name('extra-pricing-page');
Route::get('/extra/messenger-page', 'MainController@extraMessengerPage')->name('extra-messenger-page');
Route::get('/extra/data-management', 'MainController@extraDataManagement')->name('extra-data-management');
Route::get('/extra/settings-page', 'MainController@extraSettingsPage')->name('extra-settings-page');


Route::get('/home', 'MainController@home')->name('home');


//Users route and controller
Route::prefix('users')->group(function () {
Route::get('/',[UserController::class, 'index'])->name('users.index');
Route::get('/change-password',[UserController::class, 'change_password'])->name('users.change');
Route::get('/help',[UserController::class, 'help'])->name('users.help');

Route::post('/store', [UserController::class, 'store'])->name('users.store');
Route::get('/add', [UserController::class, 'create'])->name('users.create');
Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/update/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/show/{user_id}', [UserController::class, 'show'])->name('users.show');


});
// Define the login route
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

Route::get('/login/v1', 'MainController@loginV1')->name('login-v1');
Route::get('/login/v2', 'MainController@loginV2')->name('login-v2');
Route::get('/login/v3', 'MainController@loginV3')->name('login-v3');
Route::get('/register/v3', 'MainController@registerV3')->name('register-v3');

Route::get('/helper/css', 'MainController@helperCSS')->name('helper-css');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

//Lawyers Route
Route::prefix('lawyers')->group(function () {
    Route::get('/my-cases', [LawyerController::class, 'my_index'])->name('lawyers.my_index');
    Route::post('/change-password', [LawyerController::class, 'changePassword'])->name('lawyer.changePassword');

    Route::get('/', [LawyerController::class, 'index'])->name('lawyers.index');
    Route::get('/add', [LawyerController::class, 'create'])->name('lawyers.create');
    Route::post('/store', [LawyerController::class, 'store'])->name('lawyers.store');
    Route::get('/edit/{lawyer}', [LawyerController::class, 'edit'])->name('lawyers.edit');
    Route::put('/update/{lawyer}', [LawyerController::class, 'update'])->name('lawyers.update');
    Route::delete('/delete/{lawyer}', [LawyerController::class, 'destroy'])->name('lawyers.destroy');

    Route::get('/edit_', [LawyerController::class, 'edit_'])->name('lawyers.edit_');
    Route::get('/delete', [LawyerController::class, 'delete'])->name('lawyers.remove');

    Route::get('/show/{lawyer_id}', [LawyerController::class, 'show'])->name('lawyers.show');
    
    

});
Route::put('/complainants/{complainant_id}', [ComplainantsController::class, 'update'])->name('complainants.update');


Route::delete('/cases/documents/{document}', [CaseController::class, 'destroyDocument'])
    ->name('cases.documents.destroy');




Route::post('/cases/{case}/documents/store', [CaseDocumentsController::class, 'store'])->name('documents.store');

Route::delete('/cases/{case}/documents/{document}', [CaseDocumentsController::class, 'destroy'])
    ->name('documents.destroy');
    
Route::get('/cases/{case_id}/check-evaluation', [PanelEvaluationController::class, 'checkEvaluation'])->name('cases.checkEvaluation');
Route::get('/cases/{case_id}/check-assignment', [CaseController::class, 'checkAssignment']);
Route::delete('/cases/{case_id}/remove-lawyer/{lawyer_id}', [CaseController::class, 'removeAssignedLawyer']);

//Cases Route
Route::middleware(['auth'])->prefix('cases')->group(function () {
    Route::post('/{case_id}/submit-panel-evaluation', [CaseController::class, 'submitToPanelEvaluation'])->name('cases.submitToPanelEvaluation');
    
    Route::post('/send-case-email/{case_id}', [CaseController::class, 'sendEmail'])->name('cases.sendEmail');

    Route::get('/update-form', [CaseController::class, 'showUpdateForm'])->name('cases.showUpdateForm');
    Route::get('/matter', [CaseController::class, 'showMatter'])->name('cases.matter');
    Route::get('/case-activity/{id}', [CaseController::class, 'ActivityShow'])->name('cases.ActivityShow');
    Route::post('/assign-multiple', [CaseController::class, 'assignMultiple'])->name('cases.assign-multiple');
    Route::get('/{case_id}/assigned-lawyers', [CaseController::class, 'getAssignedLawyers']);
    Route::post('/addHearing', [CaseController::class, 'addHearing'])->name('cases.addHearing');
    Route::post('/addMention', [CaseController::class, 'addMention'])->name('cases.addMention');
    Route::post('/addApplication', [CaseController::class, 'addApplication'])->name('cases.addApplication');
    Route::post('/addActivity', [CaseController::class, 'addActivity'])->name('cases.addActivity');
    Route::get('/calendar/events', [CaseController::class, 'getEvents'])->name('cases.getEvents');
   // routes/web.php
   Route::post('/update-matter', [CaseController::class, 'updateMatter'])
     ->name('cases.updateMatter');

    Route::delete('/activities/{id}', [CaseController::class, 'destroyActivity'])->name('cases.deleteMatter');
    Route::get('/check-case', [CaseController::class, 'checkCase'])->name('cases.checkCase');
    Route::get('/get-last-sequence/{case_id}', [CaseController::class, 'getLastSequence']);
    Route::get('/get-last-sequence-mention/{case_id}', [CaseController::class, 'getLastSequenceMention']);
    Route::get('/get-last-sequence-application/{case_id}', [CaseController::class, 'getLastSequenceApplication']);
    Route::get('/get-last-sequence-all/{case_id}', [CaseController::class, 'getLastSequenceAll']);
    Route::get('{case}/available-lawyers', [CaseController::class, 'getLawyers'])->name('cases.available-lawyers');

    Route::get('/', [CaseController::class, 'index'])->name('cases.index');
    Route::get('/add', [CaseController::class, 'create'])->name('cases.create');
    Route::post('/store', [CaseController::class, 'store'])->name('cases.store');
    Route::get('/edit/{case}', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/update/{case}', [CaseController::class, 'update'])->name('cases.update');
    Route::post('/assign', [CaseController::class, 'assign'])->name('cases.assign');
    Route::delete('/delete/{case}', [CaseController::class, 'destroy'])->name('cases.destroy');

    Route::get('/edit_', [CaseController::class, 'edit_'])->name('cases.edit_');
    Route::get('/delete', [CaseController::class, 'delete'])->name('cases.remove');

    Route::get('/show/{case}', [CaseController::class, 'show'])->name('cases.show');



    Route::get('/view', [CaseController::class,'view'])->name('cases.view');

});

Route::post('/negotiations/{negotiation}/attachments/store', [NegotiationAttachmentController::class, 'store'])
    ->name('negotiations.attachments.store');
Route::post('/negotiations/{negotiation}/attachments/store_edit', [NegotiationAttachmentController::class, 'store_edit'])
    ->name('negotiations.attachments.store_edit');
Route::delete('/negotiations/attachments/{attachment_id}', [NegotiationAttachmentController::class, 'delete'])
    ->name('negotiations.attachments.delete');




Route::prefix('negotiations')->group(function () {
    Route::get('/check-case', [NegotiationController::class, 'checkCase'])->name('negotiations.checkCase');

    Route::get('/', [NegotiationController::class, 'index'])->name('negotiations.index');
    Route::get('/create/{case_id}', [NegotiationController::class, 'create'])->name('negotiations.create');
    Route::post('/store', [NegotiationController::class, 'store'])->name('negotiations.store');
    Route::get('/edit/{negotiation}', [NegotiationController::class, 'edit'])->name('negotiations.edit');
    Route::put('/update/{negotiation}', [NegotiationController::class, 'update'])->name('negotiations.update');
    
    Route::delete('/delete/{negotiation}', [NegotiationController::class, 'destroy'])->name('negotiations.destroy');

    Route::get('/edit_', [NegotiationController::class, 'edit_'])->name('negotiations.edit_');
    Route::get('/delete', [NegotiationController::class, 'delete'])->name('negotiations.remove');

    Route::get('/show/{negotiation}', [NegotiationController::class, 'show'])->name('negotiations.show');
});

Route::prefix('evaluations')->group(function () {   
Route::get('/', [PanelEvaluationController::class,'index'])->name('evaluations.index');
Route::get('/check-case', [PanelEvaluationController::class, 'checkCase'])->name('evaluations.checkCase');
Route::get('/create/{case_id}', [PanelEvaluationController::class, 'create'])->name('evaluations.create');
Route::post('/store', [PanelEvaluationController::class, 'store'])->name('evaluations.store');
Route::get('/show/{evaluation}', [PanelEvaluationController::class, 'show'])->name('evaluations.show');
Route::get('/edit/{evaluation}', [PanelEvaluationController::class, 'edit'])->name('evaluations.edit');
Route::put('/update/{evaluation}', [PanelEvaluationController::class, 'update'])->name('evaluations.update');

});




Route::prefix('appeals')->group(function () {  

    Route::get('/', [AppealController::class,'index'])->name('appeals.index');
    Route::get('/edit/{appeal}', [AppealController::class, 'edit'])->name('appeals.edit');
    Route::get('/check-case', [AppealController::class, 'checkCase'])->name('appeals.checkCase');
    Route::get('/create/{case_id}', [AppealController::class, 'create'])->name('appeals.create');
    Route::post('/store', [AppealController::class, 'store'])->name('appeals.store');
    Route::get('/show/{appeal_id}', [AppealController::class, 'show'])->name('appeals.show');
    Route::delete('/deleteDocuments/{documentId}', [AppealController::class, 'deleteDocument'])->name('appeals.deleteDocument');
    Route::put('/update/{appeal}', [AppealController::class, 'update'])->name('appeals.update');
    Route::post('/uploadAttachment', [AppealController::class, 'uploadAttachment'])->name('appeals.uploadAttachment');

 });



 Route::prefix('adjourns')->group(function () {


    Route::get('/', [AdjournController::class,'index'])->name('adjourns.index');
    Route::get('/edit/{appeal}', [AdjournController::class, 'edit'])->name('adjourns.edit');
    Route::get('/check-case', [AdjournController::class, 'checkCase'])->name('adjourns.checkCase');
    Route::get('/create/{case_id}', [AdjournController::class, 'create'])->name('adjourns.create');
    Route::post('/store', [AdjournController::class, 'store'])->name('adjourns.store');
    Route::get('/show/{adjourns_id}', [AdjournController::class, 'show'])->name('adjourns.show');
    Route::delete('/deleteDocuments/{documentId}', [AdjournController::class, 'deleteDocument'])->name('adjourns.deleteDocument');
    Route::put('/update/{adjourn}', [AdjournController::class, 'update'])->name('adjourns.update');
    Route::post('/uploadAttachment', [AdjournController::class, 'uploadAttachment'])->name('adjourns.uploadAttachment');

 });


 Route::prefix('witnesses')->group(function () {


    Route::get('/', [WitnessController::class,'index'])->name('witnesses.index');
    Route::get('/edit/{appeal}', [WitnessController::class, 'edit'])->name('witnesses.edit');
    Route::get('/check-case', [WitnessController::class, 'checkCase'])->name('witnesses.checkCase');
    Route::get('/create/{case_id}', [WitnessController::class, 'create'])->name('witnesses.create');
    Route::post('/store', [WitnessController::class, 'store'])->name('witnesses.store');
    Route::get('/show/{adjourns_id}', [WitnessController::class, 'show'])->name('witnesses.show');
    Route::delete('/deleteDocuments/{documentId}', [WitnessController::class, 'deleteDocument'])->name('witnesses.deleteDocument');
    Route::put('/update/{witness}', [WitnessController::class, 'update'])->name('witnesses.update');
    Route::post('/uploadAttachment', [WitnessController::class, 'uploadAttachment'])->name('witnesses.uploadAttachment');

 });



 Route::prefix('trials')->group(function () {


    
    Route::get('/', [TrialController::class,'index'])->name('trials.index');
    Route::get('/edit/{trial}', [TrialController::class, 'edit'])->name('trials.edit');
    Route::get('/check-case', [TrialController::class, 'checkCase'])->name('trials.checkCase');
    Route::get('/create/{case_id}', [TrialController::class, 'create'])->name('trials.create');
    Route::post('/store', [TrialController::class, 'store'])->name('trials.store');
    Route::get('/show/{trial_id}', [TrialController::class, 'show'])->name('trials.show');
    Route::delete('/deleteDocuments/{documentId}', [TrialController::class, 'deleteDocument'])->name('trials.deleteDocument');
    Route::put('/update/{trial}', [TrialController::class, 'update'])->name('trials.update');
    Route::post('/uploadAttachment', [TrialController::class, 'uploadAttachment'])->name('trials.uploadAttachment');


  });


  
 Route::prefix('preparations')->group(function () {


    
    Route::get('/', [TrialPreparationController::class,'index'])->name('preparations.index');
    Route::get('/edit/{preparation}', [TrialPreparationController::class, 'edit'])->name('preparations.edit');
    Route::get('/check-case', [TrialPreparationController::class, 'checkCase'])->name('preparations.checkCase');
    Route::get('/create/{case_id}', [TrialPreparationController::class, 'create'])->name('preparations.create');
    Route::post('/store', [TrialPreparationController::class, 'store'])->name('preparations.store');
    Route::get('/show/{preparation_id}', [TrialPreparationController::class, 'show'])->name('preparations.show');
    Route::delete('/deleteDocuments/{documentId}', [TrialPreparationController::class, 'deleteDocument'])->name('preparations.deleteDocument');
    Route::put('/update/{preparation}', [TrialPreparationController::class, 'update'])->name('preparations.update');
    Route::post('/uploadAttachment', [TrialPreparationController::class, 'uploadAttachment'])->name('preparations.uploadAttachment');


  });



  Route::prefix("closed_cases")->group(function () {     
    Route::get('/', [CaseClosureController::class, 'index'])->name('closed_cases.index');
    Route::get('/edit/{closure}', [CaseClosureController::class, 'edit'])->name('closed_cases.edit');
    Route::get('/check-case', [CaseClosureController::class, 'checkCase'])->name('closed_cases.checkCase');

   
    Route::get('/create/{case_id}', [CaseClosureController::class, 'create'])->name('closed_cases.create');
    Route::post('/store', [CaseClosureController::class, 'store'])->name('closed_cases.store');
    Route::get('/show/{closure_id}', [CaseClosureController::class, 'show'])->name('closed_cases.show');
    Route::delete('/deleteDocuments/{documentId}', [CaseClosureController::class, 'deleteDocument'])->name('closed_cases.deleteDocument');
    Route::put('/update/{closure}', [CaseClosureController::class, 'update'])->name('closed_cases.update');
    Route::post('/uploadAttachment', [CaseClosureController::class, 'uploadAttachment'])->name('closed_cases.uploadAttachment');
});


Route::prefix('all_payments')->group(function () { 

    Route::get('/', [PaymentController::class, 'index'])->name('all_payments.index');
    Route::get('/edit/{payment}', [PaymentController::class, 'edit'])->name('all_payments.edit');
    Route::get('/check-case', [PaymentController::class, 'checkCase'])->name('all_payments.checkCase');

   
    Route::get('/create/{case_id}', [PaymentController::class, 'create'])->name('all_payments.create');
    Route::post('/store', [PaymentController::class, 'store'])->name('all_payments.store');
    Route::get('/show/{payment_id}', [PaymentController::class, 'show'])->name('all_payments.show');
    Route::delete('/deleteDocuments/{documentId}', [PaymentController::class, 'deleteDocument'])->name('all_payments.deleteDocument');
    Route::put('/update/{payment}', [PaymentController::class, 'update'])->name('all_payments.update');
    Route::post('/uploadAttachment', [PaymentController::class, 'uploadAttachment'])->name('all_payments.uploadAttachment');



});

Route::prefix('lawyer_payments')->group(function () { 

    Route::get('/', [LawyerPaymentController::class, 'index'])->name('lawyer_payments.index');
    Route::get('/edit/{payment}', [LawyerPaymentController::class, 'edit'])->name('lawyer_payments.edit');
    Route::get('/check-case', [LawyerPaymentController::class, 'checkCase'])->name('lawyer_payments.checkCase');
    Route::get('/get-lawyers', [LawyerPaymentController::class, 'getLawyers'])->name('lawyer_payments.getLawyers');

   
    Route::get('/create/{case_id}', [LawyerPaymentController::class, 'create'])->name('lawyer_payments.create');
    Route::post('/store', [LawyerPaymentController::class, 'store'])->name('lawyer_payments.store');
    Route::get('/show/{payment_id}', [LawyerPaymentController::class, 'show'])->name('lawyer_payments.show');
    Route::delete('/deleteDocuments/{documentId}', [LawyerPaymentController::class, 'deleteDocument'])->name('lawyer_payments.deleteDocument');
    Route::put('/update/{payment}', [LawyerPaymentController::class, 'update'])->name('lawyer_payments.update');
    Route::post('/uploadAttachment', [LawyerPaymentController::class, 'uploadAttachment'])->name('lawyer_payments.uploadAttachment');

});

Route::prefix('ag_advice')->group(function () { 
    Route::get('/', [AGAdviceController::class,'index'])->name('ag_advice.index');
    Route::get('/check-case', [AGAdviceController::class, 'checkCase'])->name('ag_advice.checkCase');
    Route::get('/create/{case_id}', [AGAdviceController::class, 'create'])->name('ag_advice.create');
    Route::post('/store', [AGAdviceController::class, 'store'])->name('ag_advice.store');
    Route::get('/show/{advice}', [AGAdviceController::class, 'show'])->name('ag_advice.show');
    Route::get('/edit/{advice}', [AGAdviceController::class, 'edit'])->name('ag_advice.edit');
    Route::put('/update/{advice}', [AGAdviceController::class, 'update'])->name('ag_advice.update');
    
});

Route::prefix('dvc_appointments')->group(function () { 
    Route::get('/', [  ForwardingController::class,'index'])->name('dvc_appointments.index');
    Route::get('/check-case', [ForwardingController::class, 'checkCase'])->name('dvc_appointments.checkCase');
    Route::post('/store', [ForwardingController::class, 'store'])->name('dvc_appointments.store');
    Route::get('/show/{forwarding_id}', [ForwardingController::class, 'show'])->name('dvc_appointments.show');
    Route::get('/edit/{appointment}', [ForwardingController::class, 'edit'])->name('dvc_appointments.edit');
    Route::put('/update/{appointment}', [ForwardingController::class, 'update'])->name('dvc_appointments.update');
    Route::get('/create/{case}/{evaluation}', [ForwardingController::class, 'create'])->name('dvc_appointments.create');

});

Route::prefix('dvc')->group(function () { 


    Route::get('/', [  DvcAppointmentController::class,'index'])->name('dvc.index');
    
    Route::get('/edit/{appointment}', [DvcAppointmentController::class, 'edit'])->name('dvc.edit');
    Route::get('/check-case', [DvcAppointmentController::class, 'checkCase'])->name('dvc.checkCase');
    Route::get('/create/{case_id}', [DvcAppointmentController::class, 'create'])->name('dvc.create');
    Route::post('/store', [DvcAppointmentController::class, 'store'])->name('dvc.store');
    Route::get('/show/{appointment_id}', [DvcAppointmentController::class, 'show'])->name('dvc.show');
    Route::delete('/deleteDocuments/{documentId}', [DvcAppointmentController::class, 'deleteDocument'])->name('dvc.deleteDocument');
    Route::put('/update/{appointment}', [DvcAppointmentController::class, 'update'])->name('dvc.update');
    Route::post('/uploadAttachment', [DvcAppointmentController::class, 'uploadAttachment'])->name('dvc.uploadAttachment');



});
