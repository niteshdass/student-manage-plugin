;(function($) {
    // $('#add-student').click(function(){
        $("#profile").click(function(){
            alert("The paragraph was clicked.");
            console.log('clicked');
          });
          
        'use strict';
        var form = $('.new-student-form'),
            form_data = {},
            subject_length = $('#subject').attr("subject-length")

        const responseMessage = (message, message_type) => {
            $('.message').text(message)
            $('.message').addClass(`${message_type}-msg ${message_type}-message`)
            setTimeout(() => {
                $('.message').text("")
                $('.message').removeClass(`${message_type}-msg ${message_type}-message`)
            }, 2000)
        }
    
        form.submit(function (e) {
            e.preventDefault();
            // get form data
            form_data.name = $('#name').val();
            form_data.registration = $('#registration').val();
            form_data.dept = $('#dept').val();
            form_data.phone = $('#phone').val();
            form_data.gmail = $('#gmail').val();
            form_data.password = '12345678';
            form_data.id = $('#id').val();
            form_data.subject = [];
            // Prepare subject data
            for (let i = 1; i <= subject_length; i++) {
                if($(`.subject-${i}`).prop("checked")) {
                    form_data.subject.push($(`.subject-${i}`).val());
                }
            }
            // subject data prepare for showing after update in frontend
            let subject = '';
            for (let i = 0; i < form_data.subject.length; i++) {
                if(i === 0) {
                    subject = form_data.subject[i];
                } else {
                    subject = subject.concat(",", form_data.subject[i])
                }
            }
            // form validation and submission
            if(Object.keys(form_data).length && form_data?.name?.length) {
                // check name is strig or not
                if (form_data?.name?.length) {
                    var name = new RegExp('^[a-zA-Z ]*$');
                    if(!name.test(form_data?.name)) {
                        responseMessage('Do not cheating with me! man', 'error');
                        $("#name").focus();
                        return false;
                    }
                }
                // validation for registration
                if($('#registration').val() < 0 || $('#registration').val().length < 6)
                {
                    responseMessage('Registration number will be 6 digit real number!', 'error');
                  $("#registration").focus();
                  return false;
                }
                // validation for phone
                if($('#phone').val() < 0 || $('#phone').val().length < 11)
                {
                    responseMessage('Phone number will be minimum 11 digit real number', 'error');
                  $("#phone").focus();
                  return false;
                }

                // validation for subject
                if(!form_data?.subject?.length)
                {
                    responseMessage('Subject is requiredr', 'error');
                  return false;
                }
                // form submit
                $('#add-student').addClass("disabled")
                $('#add-student').text("Loading...")
                console.log(form_data);
                $.ajax({
                    type: 'POST',
                    url: ajax_url_new_student.ajax_url_new_student,
                    data: {
                      action: 'wpvk_new_student',
                      data: form_data
                    },
                    success: function (data) {
                        if(data.success) {
                            $('#add-student').removeClass("disabled")
                            $('#add-student').text("Add student")
                            if(form_data.id) {
                                $('#upregid').text(form_data.registration)
                                $('#upregidtop').text(`Registration ID: ${form_data.registration}`)
                                $('#upnameid').text(form_data.name)
                                $('#upphoneid').text(form_data.phone)
                                $('#upsubid').text(form_data.subject)

                                responseMessage('Student info update successfully', 'success');
                            } else {
                                responseMessage('Student add successfully', 'success');
                            }
                        } else {
                            $('#add-student').removeClass("disabled")
                            $('#add-student').text("Add student")
                            responseMessage('Something went wrong!!', 'error');
                        }
                    },
                    error: function (err) {
                        $('#add-student').removeClass("disabled")
                        $('#add-student').text("Add student")
                        console.log(err)
                        responseMessage('Something went wrong!!', 'error');
                    }
                });
            } else {
                responseMessage('Name is required!!', 'error');
                $("#name").focus();
            }
 
        });
    // });
})(jQuery);