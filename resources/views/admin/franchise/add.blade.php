@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/franchise/add" method="post" enctype="multipart/form-data">
            <h2 class="page_title">Add Franchise</h2>
            <section class="jcc">
                <div class="profile_pic field">
                    <label for="pp">
                        <img src="/images/profile/profile 1.jpg" alt="profile">
                    </label>
                    <input type="file" name="" id="pp" onchange="display_pic(this)">
                </div>
            </section>
            <section class="panel">
                @csrf
                <div class="field_group">
                    <div class="field">
                        <label for="">Franchise Name</label>
                        <input type="text" name="emp_name" placeholder="franchise Name">
                    </div>
                    <div class="field">
                        <label for="">Franchise Username</label>
                        <input type="text" name="emp_username" placeholder="franchise Username">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="">Franchise D.O.B.</label>
                        <input type="date" name="emp_dob" placeholder="franchise DOB">
                    </div>
                    <div class="field">
                        <label for="">Franchise Gender</label>
                        <select name="emp_gender" id="">
                            <option value="" disabled selected>Please Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="transgender">Transgender</option>
                        </select>
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="field">
                    <label for="">Franchise Contact (Phone No.)</label>
                    <input type="text" name="emp_contact" placeholder="franchise Contact">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="">Franchise Personal E-mail</label>
                        <input type="text" name="emp_email" placeholder="franchise E-mail">
                    </div>
                    <div class="field">
                        <label for="">E-mail Provided by Company</label>
                        <input type="text" name="emp_company_email" placeholder="franchise Company E-mail">
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="field">
                    <label for="">Franchise Address (Mentioned in Aadhar)</label>
                    <input type="text" name="emp_address" placeholder="franchise Address">
                </div>
                <div class="field">
                    <div class="field">
                        <label for="">Franchise State (Mentioned in Aadhar)</label>
                        <select name="emp_state" id="">
                            <option value="" disabled selected>Please Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state['id'] }}">
                                    {{ $state['state_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="field_group">
                    <div class="field">
                        <label for="">Franchise Joing Date</label>
                        <input type="date" name="emp_joining_date" id="">
                    </div>
                    <div class="field">
                        <label for="">Franchise Commision</label>
                        <input type="text" name="emp_salary" placeholder="Commision">
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="field">
                    <label for="">Aadhar Number</label>
                    <input type="number" name="aadhar_number" id="" placeholder="Aadhar Number">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="aadhar_front" style="border: 2px dashed #00000044;">
                            <img src="" alt="Aadhar Front Side" style="width: 100%">
                            <span>Aadhar Front Side</span>
                        </label>
                        <input type="file" onchange="display_pic(this)" name="aadhar_front" id="aadhar_front">
                    </div>
                    <div class="field">
                        <label for="aadhar_back" style="border: 2px dashed #00000044;">
                            <img src="" alt="Aadhar Back Side" style="width: 100%">
                            <span>Aadhar Back Side</span>
                        </label>
                        <input type="file" onchange="display_pic(this)" name="aadhar_back" id="aadhar_back">
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="field">
                    <label for="">Pan Number</label>
                    <input type="text" name="pan_number" id="" placeholder="Pan Number">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="pan_pic" style="border: 2px dashed #00000044;">
                            <img src="" alt="Pan Card Pic" style="width: 100%">
                            <span>Pan Card Pic</span>
                        </label>
                        <input type="file" onchange="display_pic(this)" name="pan_pic" id="pan_pic">
                    </div>
                    <div class="field"><label></label></div>
                </div>
            </section>
            <section class="panel">
                <div class="field_group">
                    <div class="field">
                        <label for="">Bank Details</label>
                        <input type="text" name="account_number" id="" placeholder="Account Number">
                    </div>
                    <div class="field">
                        <label for="">Bank IFSC</label>
                        <input type="text" name="ifsc" id="" placeholder="Account Number">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="">UPI Id</label>
                        <input type="text" name="upi" id="" placeholder="UPI Id">
                    </div>
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="bank_pic" style="border: 2px dashed #00000044;">
                            <img src="" alt="Bank Passbook Pic" style="width: 100%">
                            <span>Bank Passbook Pic</span>
                        </label>
                        <input type="file" onchange="display_pic(this)" name="bank_pic" id="bank_pic">
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="field">
                    <label for="">Franchise Password (Can only be changed by developer)</label>
                    <input type="password" name="emp_password" placeholder="Password">
                </div>
            </section>
            <div class="field">
                <input type="checkbox" name="fran_status" id="fran_status" value="1">
                <label for="fran_status">Activate this Franchise</label>
            </div>
            <div class="p-4 text-end">
                <button class="btn btn-primary" type="submit">Add Franchise</button>
            </div>
        </form>
    </main>
    @push('script')
        <script>
            function display_pic(node) {
                $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
            }
        </script>
    @endpush
@endsection
