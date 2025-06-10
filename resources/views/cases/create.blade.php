

@extends('layouts.default')

@section('title', 'Create Case')



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
            <h4 class="panel-title">Create New Case</h4>
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
                <label class="nav-link shadow-sm step1 border mx-2">Claimant Details</label>
                <label class="nav-link shadow-sm step2 border mx-2">Documents</label>
            </div>
            
           <form action="{{ route('cases.store') }}" method="POST" class="employee-form" enctype="multipart/form-data">
                @csrf
                
                <!-- Step 1: Case Details -->
                
                <div class="form-section current">
                    
                <!-- Case Number & Case Name -->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mt-3 mb-2">
                <label for="case_number" class="control-label">Case Number</label>
                <input type="text" name="case_number" class="form-control" placeholder="Enter case number" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mt-3 mb-2">
                <label for="case_number" class="control-label">Track Number/Reference Number</label>
                <input type="text" name="track_number" class="form-control" placeholder="Enter track number" required>
            </div>
            
              
        </div>
        <div class="col-md-4">
            <div class="form-group mt-3 mb-2">
                <label for="case_name" class="control-label">Case Name/ Citation</label>
                <input type="text" name="case_name" class="form-control" placeholder="Enter case name" required>
            </div>
        </div>
    </div>


    <!-- Case Category & Case Status -->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mt-3 mb-2">
                <label for="case_category" class="control-label">Case Category</label>
                <select name="case_category" class="form-control">
                    <option value="Academic">Academic</option>
                    <option value="Disciplinary">Disciplinary</option>
                    <option value="Administrative">Administrative</option>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                    <option value="supplier">Supplier</option>
                    <option value="staff union">Staff Union</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mt-3 mb-2">
                <label for="initial_status" class="control-label">Initial Status</label>
                <select name="initial_status" class="form-control">
                    <option value="Under Review">Under Review</option>
                    <option value="Approved">Approved</option>
                   
                    <option value="Needs Negotiation">Needs Negotiation</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group mt-3 mb-2">
                <label for="case_status" class="control-label">Case Status</label>
                <select name="case_status" class="form-control">
                    <option value="Hearing">Hearing</option>
                    <option value="Application">Application</option>
                    <option value="Mention">Mention</option>
                    <option value="Review">Review</option>
                    <option value="Panel Evaluation">Panel Evaluation</option>
                    <option value="Waiting for Panel Evaluation">Waiting for Panel Evaluation</option>
                    <option value="Waiting for AG Advice">Waiting for AG Advice</option>
                    <option value="Forwarded to DVC">Forwarded to DVC</option>
                    <option value="Appeal">Appeal</option>
                    <option value="Trial">Trial</option>
                    <option value="Adjourned">Adjourned</option>
                    <option value="Under Trial">Under Trial</option>
                    <option value="Negotiation">Negotiation</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>
        </div>

      
    </div>


            <!-- Initial Status, First Hearing Date & Date Received in One Row -->
        <div class="row">
            
           

            <div class="col-md-4">
                <div class="form-group mt-3 mb-2">
                    <label for="date_received" class="control-label">Date & Time Received</label>
                    <input type="datetime-local" name="date_received" class="form-control" required>
                </div>
            </div>
            <div class="col-md-8">

            <div class="form-group">
                <label>Description</label>
                <textarea name="case_description" class="form-control" required></textarea>
            </div>

            </div>
            
        </div>

        
                   
                </div>

                <!-- Step 2: Case Status -->
                <div class="form-section">
                    <!-- Complainant Details -->
                    <div class="row">
    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="complainant_name" class="control-label">Claimant Name</label>
            <input type="text" name="complainant_name" class="form-control" placeholder="Enter complainant name" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="phone" class="control-label">Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
        </div>
    </div>
                </div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="email" class="control-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email address">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mt-3 mb-2">
            <label for="address" class="control-label">Address</label>
            <input type="text" name="address" class="form-control" placeholder="Enter address">
        </div>
    </div>
</div>

                </div>

              <!-- Step 3: Additional Information -->
                <div class="form-section">
                    <h5>Upload Documents</h5>
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

@endprepend

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById("documentInput");
        const previewContainer = document.getElementById("file-preview");
        let selectedFiles = [];

        fileInput.addEventListener("change", function (event) {
            const files = Array.from(event.target.files);
            selectedFiles = [...selectedFiles, ...files]; // Merge new files with existing

            displayFiles();
        });

        function displayFiles() {
            previewContainer.innerHTML = ""; // Clear previous preview

            selectedFiles.forEach((file, index) => {
                const fileRow = document.createElement("div");
                fileRow.classList.add("d-flex", "align-items-center", "mb-2");

                fileRow.innerHTML = `
                    <span class="me-2">${file.name}</span>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFile(${index})">Delete</button>
                `;

                previewContainer.appendChild(fileRow);
            });

            updateFileInput();
        }

        window.removeFile = function (index) {
            selectedFiles.splice(index, 1);
            displayFiles();
        };

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }
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