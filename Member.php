<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to left, #3f5efb, #fc466b);
            margin: 0;
            padding: 20px;
            background-size: cover;
            background-repeat: no-repeat;
        }
        h1{
            text-align: center;
            margin-bottom: 20px;
            color: #333;

        }
    
        .container {
            max-width: 500px;
            margin: auto;
            background: linear-gradient(to right, #3f5efb, #fc466b);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="file"],
        select {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            cursor: pointer;
            padding: 10px 20px;
            background-color:  #3f5efb;
            color: white;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: 50%;
            margin: auto;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        input[type="submit"]:hover {
            background-color:  #fc466b;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background-color: #f5f5f5;
            font-size: 14px;
            box-shadow:  0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
</head>
<body>
    <h1>Add New Member</h1>

    <div class="container">
        <form id="addMemberForm" action="add_member.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone">
            
            <label for="regNumber">Registration Number:</label>
            <input type="text" id="regNumber" name="regNumber" required>
            
            <label for="yearOfStudy">Year of Study:</label>
            <select id="yearOfStudy" name="yearOfStudy" required>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
                <option value="5">5th Year</option>
            </select>
            
            <label for="profilePicture">Profile Picture:</label>
            <input type="file" id="profilePicture" name="profilePicture" required>
            
            <label for="courseOfStudy">Course of Study:</label>
            <input type="text" id="courseOfStudy" name="courseOfStudy" required>
            
            <input type="submit" value="Submit">
        </form>
    </div>
        <footer>
            <p>&copy;2024 All Rights Reserved</p>
        </footer>
    <script src="member.js"></script>
</body>
</html>
