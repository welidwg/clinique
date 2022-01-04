<?php
$current = "AddMed";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
$connect = connect_bdd();

if ($_SESSION["login"] && $_SESSION["role"] == 4) {
    $role = $_SESSION["role"];


?>
    <style>
        #addMedform input,
        #addMedform textarea {
            width: 50%;
            margin: 0 auto;
        }
    </style>
    <script>
        jQuery(function($) {





            $('#nom').on('keyup', function() {
                var val = $(this).val();
                $.ajax({
                    url: "../PHP_SCRIPT/Utiles.php",
                    data: {
                        username: val,
                        query: "AddUser_usrname"
                    },
                    type: "GET",
                    success: function(data) {
                        if (data == 1) {
                            $("#username").css("color", "limegreen");
                            $("#errors").css("display", "none");
                            $("#submit").removeAttr("disabled");
                            $("#usernameErr").css("display", "none");


                        } else {
                            $("#username").css("color", "red");
                            $("#errors").css("display", "block");
                            $("#usernameErr").css("display", "block");
                            $("#submit").attr("disabled", "disabled");
                        }
                    }
                });
            });
            $('#mail').on('keyup', function() {
                var val = $(this).val();
                $.ajax({
                    url: "../PHP_SCRIPT/Utiles.php",
                    data: {
                        mail: val,
                        query: "AddUser_mail"
                    },
                    type: "GET",
                    success: function(data) {
                        if (data == 1) {
                            $("#mail").css("color", "limegreen");
                            $("#errors").css("display", "none");
                            $("#submit").removeAttr("disabled");
                            $("#mailErr").css("display", "none");


                        } else {
                            $("#mail").css("color", "red");
                            $("#errors").css("display", "block");
                            $("#mailErr").css("display", "block");
                            $("#submit").attr("disabled", "disabled");
                        }
                    }
                });
            });

        })(jQuery);
    </script>


    <div class="row">

        <div class="col-12 col-lg-0">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title" style="text-align: center;">Ajouter Médicament</h5>
                </div>
                <div class="card-body">
                    <script>
                        jQuery(function($) {
                            $("#addMedform").on("submit", function(e) {
                                e.preventDefault();
                                var form = $(this)[0];
                                var formData = new FormData(form);
                                $.ajax({
                                    type: "post",
                                    url: "./PHP_SCRIPT/middleware.php",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(data) {
                                        if (data == 1) {
                                            alertify.success("Ajout avec succées");
                                            $("#addMedform").trigger("reset")

                                        } else {
                                            alertify.error(data)
                                        }

                                    },
                                    error: function(e, res, err) {
                                        alertify.error(e.responseText)
                                    }
                                })
                            })


                           
                            $('#code').on("keyup", function() {
                                $.ajax({
                                    url: "PHP_SCRIPT/middleware.php",
                                    type: "post",
                                    data: {
                                        query: "MedCode",
                                        data: $(this).val(),
                                    },
                                    success: function(data) {
                                        if (data == 1) {
                                            alertify.error("Code déja existante!");
                                            $("#code").css("border", "1px solid red");
                                            $('#submit').attr("disabled", true);

                                        } else if (data == 0) {
                                            $("#code").css("border", "1px solid #ccc");
                                            $('#submit').removeAttr("disabled");
                                        }
                                    }
                                })
                            })

                        })
                    </script>

                    <form id="addMedform" enctype="multipart/form-data">
                        <input minlength="4" id="code" type="text" name="code" class="form-control" placeholder="Code de medicament " required><br>

                        <input minlength="5" id="nom" type="text" name="nom" class="form-control" placeholder="Nom de medicament " required><br>
                        <input  type="number" min="1" class="form-control" name="stock" placeholder="Stock">
                        <input type="hidden" name="ajouterMed"><br>
                        <input  id="submit" type="submit" name="add" value="Ajouter" class="form-control" placeholder="Date naissance"> <br>

                    </form>


                </div>
            </div>
        </div>







    </div>

<?php
} ?>