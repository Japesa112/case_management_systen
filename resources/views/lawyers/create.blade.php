@extends('layouts.default')

@section('title', 'Add Lawyer')

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
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="page-header">Add Lawyer</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"> Lawyer Registration Form</h4>
                </div>
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST"  class="lawyer-form">
                        @csrf
                    <div class="form-section current">
                        <h4 class="mt-4">User Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="full_name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" required>
                                </div>
                                <!--
                                <div class="form-group mt-2">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>
                            -->
                                <div class="form-group mt-2">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>

                                
                            </div>
                            <div class="col-md-6">

                                <!--
                                <div class="form-group mt-2">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            -->
                                <!-- Step 1: Select Role -->
                
                                <div class="form-group mt-2">
                                    <label for="role">Select Role</label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="lawyer">Choose...</option>
                                      
                                        <option value="lawyer">Lawyer</option>
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="mt-4">Lawyer Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="license_number">License Number <span class="text-danger">*</span></label>
                                    <input type="text" name="license_number" id="license_number" class="form-control" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="area_of_expertise">Area of Expertise</label>
                                    <input type="text" name="area_of_expertise" id="area_of_expertise" class="form-control">
                                </div>
                           
                                <div class="form-group mt-2">
                                    <label for="working_hours">Working Hours <span class="text-danger">*</span></label>
                                    <input type="text" name="working_hours" id="working_hours" class="form-control">
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="firm_name">Firm Name</label>
                                    <input type="text" name="firm_name" id="firm_name" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="years_experience">Years of Experience</label>
                                    <input type="number" name="years_experience" id="years_experience" class="form-control">
                                </div>
                            </div>
                        </div>
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
    </div>
</div>
@endsection

@prepend('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
@endprepend
@push('scripts')


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
            $('.lawyer-form').parsley().whenValidate({
                group:'block-'+curIndex()
            }).done(function(){
                let role = $('#role').val();
                console.log(role);

               

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