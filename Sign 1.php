<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $server = "localhost";
    $user = "root";
    $pw = "";
    $db = "my secretary";

    $conn = new mysqli($server, $user, $pw, $db);

    if($conn->connect_error){
       die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
   }

     $user = $_POST['Us'];
     $pass = $_POST['pw'];
     $confirmPass = $_POST['Cpw'];
     $firstName = $_POST['Fn'];
     $lastName = $_POST['Ln'];
     $email = $_POST['EA'];
     $phone = $_POST['Pn'];

     if ($pass !== $confirmPass) {
        echo json_encode(['error' => 'Passwords do not match.']);
        exit();
    }

     $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
     $stmt->bind_param("ss", $user, $email);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($result->num_rows > 0) {
         $errors = [];
         if ($result->fetch_assoc()) {
             $errors[] = 'Username or email already exists.';
        }
         echo json_encode(['error' => implode(' ', $errors)]);
         exit();
    }

     $stmt = $conn->prepare("INSERT INTO users (Username, Password, First Name, Last Name, Gmail, Phone Number) VALUES ($user, $pass, $confirmPass, $firstName, $lastName, $phone)");
     $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
     $stmt->bind_param("ssssss", $user, $hashedPassword, $firstName, $lastName, $email, $phone);

     if ($stmt->execute()) {
          echo json_encode(['success' => 'New record created successfully']);
    } else {
          echo json_encode(['error' => 'Error: ' . $stmt->error]);
    }

     $stmt->close();
     $conn->close();
        
    ?>
</body>
</html>