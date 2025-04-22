

@extends('layouts.default')

@section('title', 'Update Case')



@push('styles')

<style>
   .form-section{
    display: none;
}

.form-section.current{
    display: inline;
}
.parsley-errors-list{
    color:rgb(0, 255, 85);
}

</style>
@endpush

@section('content')
<div class="container">
    <div class="panel panel-inverse mt-5">
        <div class="panel-heading">

            <h4 class="panel-title">Update case:  {{ $case->case_number }} </h4>
            <div class="panel-heading d-flex justify-content-between align-items-center"> 
                
                <h4 class="panel-title mb-0">{{ $case->case_name }}</h4>
            </div>
            
        </div>
        <div class="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          
            <div class="nav nav-fill my-3">
                <label class="nav-link shadow-sm step0 border mx-2">Case</label>
                <label class="nav-link shadow-sm step1 border mx-2">Complainant Details</label>
                <label class="nav-link shadow-sm step2 border mx-2">Documents</label>
            </div>
            
           <form action="{{ route('cases.update', ['case' => $case]) }}" method="POST" class="employee-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Step 1: Case Details -->
                
                <div class="form-section current">
                    
                <!-- Case Number & Case Name -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-3 mb-2">
                <label for="case_number" class="control-label">Case Number</label>
                <input type="text" name="case_number" class="form-control" value="{{ $case->case_number }}" placeholder="Enter case number" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-3 mb-2">
                <label for="case_name" class="control-label">Case Name</label>
                <input type="text" name="case_name" value="{{ old('case_name', $case->case_name ?? '') }}" class="form-control" placeholder="Enter case name" required>
            </div>
        </div>
    </div>


    <!-- Case Category & Case Status -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mt-3 mb-2">
                <label for="case_category" class="control-label">Case Category</label>
                <select name="case_category" class="form-control">
                    <option value="Academic" {{ old('case_category', $case->case_category ?? '') == 'Academic' ? 'selected' : '' }}>Academic</option>
                    <option value="Disciplinary" {{ old('case_category', $case->case_category ?? '') == 'Disciplinary' ? 'selected' : '' }}>Disciplinary</option>
                    <option value="Administrative" {{ old('case_category', $case->case_category ?? '') == 'Administrative' ? 'selected' : '' }}>Administrative</option>
                    <option value="student" {{ old('case_category', $case->case_category ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="staff" {{ old('case_category', $case->case_category ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="supplier" {{ old('case_category', $case->case_category ?? '') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                    <option value="staff union" {{ old('case_category', $case->case_category ?? '') == 'staff union' ? 'selected' : '' }}>Staff Union</option>
                </select>
                
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-3 mb-2">
                <label for="case_status" class="control-label">Case Status</label>
                <select name="case_status" class="form-control">
                    <option value="Waiting for First Hearing" {{ old('case_status', $case->case_status ?? '') == 'Waiting for First Hearing' ? 'selected' : '' }}>Waiting for First Hearing</option>
                    <option value="Under Review" {{ old('case_status', $case->case_status ?? '') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                    <option value="Waiting for Panel Evaluation" {{ old('case_status', $case->case_status ?? '') == 'Waiting for Panel Evaluation' ? 'selected' : '' }}>Waiting for Panel Evaluation</option>
                    <option value="Waiting for AG Advice" {{ old('case_status', $case->case_status ?? '') == 'Waiting for AG Advice' ? 'selected' : '' }}>Waiting for AG Advice</option>
                    <option value="Forwarded to DVC" {{ old('case_status', $case->case_status ?? '') == 'Forwarded to DVC' ? 'selected' : '' }}>Forwarded to DVC</option>
                    <option value="Under Trial" {{ old('case_status', $case->case_status ?? '') == 'Under Trial' ? 'selected' : '' }}>Under Trial</option>
                    <option value="Judgement Rendered" {{ old('case_status', $case->case_status ?? '') == 'Judgement Rendered' ? 'selected' : '' }}>Judgement Rendered</option>
                    <option value="Closed" {{ old('case_status', $case->case_status ?? '') == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
                
            </div>
        </div>
    </div>


            <!-- Initial Status, First Hearing Date & Date Received in One Row -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mt-3 mb-2">
                    <label for="initial_status" class="control-label">Initial Status</label>
                    <select name="initial_status" class="form-control">
                        <option value="Under Review" {{ old('initial_status', $case->initial_status ?? '') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Approved" {{ old('initial_status', $case->initial_status ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ old('initial_status', $case->initial_status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Needs Negotiation" {{ old('initial_status', $case->initial_status ?? '') == 'Needs Negotiation' ? 'selected' : '' }}>Needs Negotiation</option>
                    </select>
                 </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mt-3 mb-2">
                    <label for="first_hearing_date" class="control-label">First Hearing Date</label>
              <input type="date" name="first_hearing_date" class="form-control" 
                    value="{{ old('first_hearing_date', $case->first_hearing_date ?? '') }}">
             
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3 mb-2">
                    <label for="date_received" class="control-label">Date Received</label>
                    <input type="date" name="date_received" class="form-control" 
                    value="{{ old('date_received', $case->date_received ?? '') }}" required>
                             </div>
            </div>
        </div>

        
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="case_description" class="form-control">{{ old('case_description', $case->case_description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Step 2: Case Status -->
                <div class="form-section">
                    <!-- Complainant Details -->
                    <div class="row">
    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="complainant_name" class="control-label">Complainant Name</label>
            <input type="text" name="complainant_name" class="form-control" 
            value="{{ old('complainant_name', $complainant->complainant_name ?? '') }}" 
            placeholder="Enter complainant name" required>
             </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="phone" class="control-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $complainant->phone ?? '') }}" placeholder="Enter phone number">
        </div>
    </div>
                </div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="email" class="control-label">Email</label>
            <input type="email" name="email" class="form-control"
            value="{{ old('email', $complainant->email ?? '') }}"
            placeholder="Enter email address">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="address" class="control-label">Address</label>
            <input type="text" name="address" class="form-control"
            value="{{ old('address', $complainant->address ?? '') }}"
            placeholder="Enter address">
        </div>
    </div>
</div>

                </div>

              <!-- Step 3: Additional Information -->
              <div class="form-section">
                <h4 style="margin-left: 50%; text-decoration: solid;">Documents</h4>
            
                <!-- Display Existing Documents -->
                @if ($caseDocuments && $caseDocuments->count() > 0)

                 <h5>Uploaded Documents </h5>
                 <ul class="list-group">
                    @foreach ($caseDocuments as $document)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ asset('storage/documents/' . $document->document_name) }}" target="_blank">
                                {{ $document->document_name }}
                            </a>
                
                            <button type="button" class="btn btn-danger btn-sm delete-document-btn"
                                    data-id="{{ $document->document_id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </li>
                    @endforeach
                </ul>
                
                @else
                    <p class="text-muted">No documents uploaded yet.</p>
                @endif
            
                <!-- Upload New Documents -->
                <div class="form-group mt-3 mb-2">
                    <label for="documents">Upload Files</label>
                    <input type="file" id="documentInput" name="documents[]" class="form-control @error('documents.*') is-invalid @enderror" multiple>
                    @error('documents.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Preview Section -->
                <div id="file-preview" class="mt-3"></div>
            </div>
            



                <!-- Navigation Buttons -->
                <div class="form-navigation d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary previous">Previous</button>
                    <button type="button" class="btn btn-primary next">Next</button>
                    <button type="submit" class="btn btn-success submit" style="display: none;">Submit</button>
                </div>
                

            </form>
        </div>
    </div>
</div>
@endsection


@prepend('scripts')
    {{-- Include jQuery (if not already in layout) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- Include jQuery UI with Sortable --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endprepend

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-document-btn").forEach(button => {
            button.addEventListener("click", function () {
                let documentId = this.getAttribute("data-id");

                swal({
                    title: "Are you sure?",
                    text: "Do you really want to delete this document?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            visible: true,
                            className: "btn btn-default",
                            closeModal: true
                        },
                        confirm: {
                            text: "Yes, Delete",
                            value: true,
                            visible: true,
                            className: "btn btn-danger",
                            closeModal: true
                        }
                    }
                }).then((willDelete) => {
                    if (willDelete) {
                        fetch(`/cases/documents/${documentId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                "Accept": "application/json"
                            }
                        }).then(response => {
                            if (response.ok) {
                                // Remove the document from the UI
                                button.closest("li").remove();
                                swal("Deleted!", "The document has been deleted.", "success");
                            } else {
                                swal("Error!", "Something went wrong.", "error");
                            }
                        }).catch(error => {
                            console.error("Error deleting document:", error);
                            swal("Error!", "Something went wrong.", "error");
                        });
                    }
                });
            });
        });
    });
</script>

<script>

    console.log('Hello from the create case page');
    
    $(function(){
        var $sections=$('.form-section');

        function navigateTo(index){

            $sections.removeClass('current').eq(index).addClass('current');

            $('.form-navigation .previous').toggle(index>0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [Type=submit]').toggle(atTheEnd);

     
            const step= document.querySelector('.step'+index);
            step.style.backgroundColor="#17a2b8";
            step.style.color="white";



        }

        function curIndex(){

            return $sections.index($sections.filter('.current'));
        }

        $('.form-navigation .previous').click(function(){
            navigateTo(curIndex() - 1);
        });

        $('.form-navigation .next').click(function(){
            $('.employee-form').parsley().whenValidate({
                group:'block-'+curIndex()
            }).done(function(){
                navigateTo(curIndex()+1);
            });

        });

        $sections.each(function(index,section){
            $(section).find(':input').attr('data-parsley-group','block-'+index);
        });


        navigateTo(0);



    });

</script>
@endpush