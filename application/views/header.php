<html>
        <head>
                <title>Product Uploader</title>
                
                <!-- jQuery includes -->
                <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        
                <!-- Bootstrap includes -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
                <script>

                // Only allow numerical characters in textbox
                function isNumber(evt)
                {
                    var charCode = (evt.which) ? evt.which : event.keyCode;

                    if (charCode > 31 && (charCode < 45 || charCode > 57))
                        return false;

                    return true;
                }

                </script>        
        </head>
        
        <body style="background: gainsboro">
