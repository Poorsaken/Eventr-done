<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<script>
      
        function Logout() {
            window.location.href = 'logout.php';
        }
        function ActiveEvents() {
            window.location.href = 'landingpage.php';
        }
        function CancelledEvents() {
            window.location.href = 'cancelledevents.php';
        }
        function AddEvents() {
            window.location.href = 'addevents.php';
        }
        function UpdateEvents() {
            window.location.href = 'updatevents.php';
        }
        function DeleteEvents() {
            window.location.href = 'deleteevents.php';
        }
        function EventApproval() {
            window.location.href = 'eventapproval.php';
        }



        //USER ROUTES FUNCTION
        function UserCancelledEvents() {
                    window.location.href = 'usercancelledevent.php';
                }
        function UserAddEvents() {
                    window.location.href = 'useraddevent.php';
                }

         function UserActiveEvents() {
            window.location.href = 'useractiveevent.php';
        }

    </script>

</body>
</html>