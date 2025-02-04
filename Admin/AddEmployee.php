<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>

<body>


    <!-----------SideBar Section------------------->
    <?php include('sidebar.php'); ?>


    <!----------------Main Header Section--------------------->
    <section id="main-page">
        <?php include('Header.php'); ?>


        <!----------------Main Page Design--------------------->
        <main id="page-content">


            <!-- Record Table -->

            <div class="form-records">
            <div class="container mt-5 emp-record">
        <h4 style="text-align:center;margin-bottom:40px;font-weight:600;">Employee Information Form</h4>

        <!-- Form starts here -->
        <form action="" method="POST">

            <!-- Personal Information Section -->
            <div class="section">
                <p class="sec-title"><span class="las la-sort"></span> Personal Information</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label" >Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Employee Name"  name="name" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="department" class="form-label" >Department</label>
                            <input type="text" class="form-control" id="department" name="department" placeholder="Work deparment" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label><br>
                            <div style="margin-top:8px">
                            <span style="margin-right:6px; font-size:14px"><input type="radio" name="gender" value="Male" required> Male</span>
                            <span style="margin-right:6px; font-size:14px"><input type="radio" name="gender" value="Female" required> Female</span>
                            <span style="margin-right:6px; font-size:14px"><input type="radio" name="gender" value="Other" required> Other</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Information Section -->
            <div class="section mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter designation " required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="qualification" class="form-label">Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Enter qualification" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="duty_station" class="form-label">Duty Station</label>
                            <input type="text" class="form-control" id="duty_station" name="duty_station" placeholder="Enter duty station" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Knowledge Assessment Section -->
            <div class="section mt-4">
    <p class="sec-title"><span class="las la-sort"></span> Knowledge Assessment Questions</p>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="knowledge_organizational_vision" class="form-label question">Knowledge about Organizational Vision, Mission & Objectives</label>
                <div class="radio-group">
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_vision" value="Excellent" required> Excellent
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_vision" value="Good" required> Good
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_vision" value="Average" required> Average
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_vision" value="Poor" required> Poor
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_vision" value="Very Poor" required> Very Poor
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="knowledge_organizational_values" class="form-label question">Knowledge about Organizational Values</label>
                <div class="radio-group">
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_values" value="Excellent" required> Excellent
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_values" value="Good" required> Good
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_values" value="Average" required> Average
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_values" value="Poor" required> Poor
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_values" value="Very Poor" required> Very Poor
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="knowledge_organizational_functions" class="form-label question">Knowledge about Organizational Functions</label>
                <div class="radio-group">
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_functions" value="Excellent" required> Excellent
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_functions" value="Good" required> Good
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_functions" value="Average" required> Average
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_functions" value="Poor" required> Poor
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_organizational_functions" value="Very Poor" required> Very Poor
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="knowledge_section_functions" class="form-label question">Knowledge about Functions of the Section in which Employee is Working</label>
                <div class="radio-group">
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_section_functions" value="Excellent" required> Excellent
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_section_functions" value="Good" required> Good
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_section_functions" value="Average" required> Average
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_section_functions" value="Poor" required> Poor
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_section_functions" value="Very Poor" required> Very Poor
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="knowledge_job_responsibilities" class="form-label question">Knowledge about the Job/Responsibilities of the Employee/Staff</label>
                <div class="radio-group">
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_job_responsibilities" value="Excellent" required> Excellent
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_job_responsibilities" value="Good" required> Good
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_job_responsibilities" value="Average" required> Average
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_job_responsibilities" value="Poor" required> Poor
                    </span>
                    <span class="radio-wrapper">
                        <input type="radio" name="knowledge_job_responsibilities" value="Very Poor" required> Very Poor
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>



            <!-- Job Mastery Section -->
            <div class="section mt-4">
                <p class="sec-title"><span class="las la-sort"></span>Command or level of mastery over job role</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="command_full" class="form-label">Areas of Your Job You Have Full Command</label>
                            <textarea type="text" class="form-control" id="command_full" name="command_full"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="command_partial" class="form-label">Areas of Your Job You Have Partial Command</label>
                            <textarea type="text" class="form-control" id="command_partial" name="command_partial"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="command_low" class="form-label">Areas of Your Job You Have Low Command</label>
                            <textarea type="text" class="form-control" id="command_low" name="command_low"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Opportunities Section -->
            <div class="section mt-4">
                <p class="sec-title"><span class="las la-sort"></span> Training Needs</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="learning_area" class="form-label">Specify the Area/Field/Disciplines You Would Like to Learn</label>
                            <textarea type="text" class="form-control" id="learning_area" name="learning_area" ></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="learning_improvement" class="form-label">Specify Which of Your Job Roles Will Be Improved with This Learning</label>
                            <textarea type="text" class="form-control" id="learning_improvement" name="learning_improvement"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workshop, Certification, and Mentoring Section -->
            <div class="section mt-4">
                <p class="sec-title"><span class="las la-sort"></span>Preferred method of learning/ attaining mastery/ expertise/ skills:</p>
                
                <!-- Workshop -->
                <p class="sec-subtitle">Training Workshop:</p>

                <div class="row">


                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="workshop_topic" class="form-label">Topics</label>
                            <input type="text" class="form-control" id="workshop_topic" name="workshop_topic">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="workshop_duration" class="form-label">Workshop Duration</label>
                            <input type="text" class="form-control" id="workshop_duration" name="workshop_duration">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label>Available</label><br>
                            <input type="radio" name="workshop_availability" value="Yes"> Yes
                            <input type="radio" name="workshop_availability" value="No"> No
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="workshop_provider" class="form-label">If Yes, Who Offer? / If No, will develop</label>
                            <input type="text" class="form-control" id="workshop_provider" name="workshop_provider">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="workshop_financial_details" class="form-label">Financial details</label>
                            <input type="text" class="form-control" id="workshop_financial_details" name="workshop_financial_details">
                        </div>
                    </div>
                </div>

                <!-- Certification -->
                <p class="sec-subtitle">Certification Details:</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="certification_topic" class="form-label">Topics</label>
                            <input type="text" class="form-control" id="certification_topic" name="certification_topic">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="certification_duration" class="form-label">Certification Duration</label>
                            <input type="text" class="form-control" id="certification_duration" name="certification_duration">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label>Available</label><br>
                            <input type="radio" name="certification_availability" value="Yes"> Yes
                            <input type="radio" name="certification_availability" value="No"> No
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="certification_provider" class="form-label">If Yes, Who offers? / If No, who will develop</label>
                            <input type="text" class="form-control" id="certification_provider" name="certification_provider">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="certification_financial_details" class="form-label">Financial details</label>
                            <input type="text" class="form-control" id="certification_financial_details" name="certification_financial_details">
                        </div>
                    </div>
                </div>

                <!-- Mentoring -->
                <p class="sec-subtitle">In House Session from seniors:</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mentoring_topic" class="form-label">Topics </label>
                            <input type="text" class="form-control" id="mentoring_topic" name="mentoring_topic">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mentoring_duration" class="form-label">Mentoring Duration</label>
                            <input type="text" class="form-control" id="mentoring_duration" name="mentoring_duration">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label>Available</label><br>
                            <input type="radio" name="mentoring_availability" value="Yes"> Yes
                            <input type="radio" name="mentoring_availability" value="No"> No
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="in_house_session_provider" class="form-label">If Yes, Who offers? / If No, who will develop</label>
                            <input type="text" class="form-control" id="in_house_session_provider" name="in_house_session_provider">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="in_house_session_financial_details" class="form-label">Financial details</label>
                            <input type="text" class="form-control" id="in_house_session_financial_details" name="in_house_session_financial_details">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
        <!-- Form ends here -->
    </>
   
            </>
        </main>
    </section>
</body>