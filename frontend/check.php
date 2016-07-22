<?php    
    // We don't need action for this tutorial, but in a complex code you need a way to determine Ajax action nature
    $action = $_POST['action']; 
    // Decode JSON object into readable PHP object
    
    parse_str($_POST['formData'], $formData);
    // Get username
    $username = $formData['username']; 
    // Get password
    $password = $formData['password']; 
 
    // Lets say everything is in order
    $output = array('status' => false, 'message' => 'Not Welcome!');
    if ($username=="demo" && $password=="dem0"){
        $output = array('status' => true, 'message' => 'Welcome!');
    }
    echo json_encode($output);
?>