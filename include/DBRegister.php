<?php

include "DBConnect.php";

class DBRegister extends DBConnect
{
    public function __construct()
    {
        // Constructing DBConnect with the MySQL information
        parent::__construct("localhost", "root", "", "formdb", "utf8");
    }

    public function Register($firstName, $lastName, $email)
    {
        // Connecting to MySQL with DBConnect class
        $response = $this->Connect();

        // Handling response from the connection function
        if ($response[0]) {
            try {

                // Inserting form data into the SQL table
                $prepare = $response[1]->prepare("INSERT INTO users (firstName,lastName,email) VALUES (?,?,?)");
                $inserted = $prepare->execute([$firstName, $lastName, $email]);

                // Sending E-mail to "test@developers-alliance.com" if the data was added to the table successfully
                if ($inserted) {
                    $emailToBeSent = "
                    \r----------> New incoming sign up <----------
                    \r
                    \rFirst Name: {$firstName}
                    \rLast Name: {$lastName}
                    \rE-mail: {$email}
                    \r
                    \r----------> New incoming sign up <---------- 
                    \r======> Code Written by Luka Rusadze <======
                    ";

                    mail("test@developers-alliance.com", "Sign-Up Form Details", $emailToBeSent, "From: internshipsendmailtest@gmail.com");
                }

                // Returning a string representing the outcome of insertion so that it can be displayed on the website
                return $inserted ? "Inserted Info Into The Database Successfully" : "Insertion Failed";
            } catch (PDOException $ex) {
                // Returning exceptions so that they can be displayed on the website
                return $ex;
            }
        } else {
            return $response[1];
        }
    }
}
