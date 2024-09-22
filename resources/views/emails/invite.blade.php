<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Invite to Workspace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        h2 {
            color: #007bff;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .invite-form {
            margin-top: 20px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>You are invited to join <strong>{{ $workspaceName }}</strong></h1>
        <p>Click the button below to join:</p>
       <a href="{{ $linkInvite . '?email=' . urlencode($email) }}" class="btn">Join Workspace</a>
    </div>
</body>

</html>
