<?php
            $to  = 'saini1.rs.ravi@gmail.com';
            
            // subject
            $subject = 'Activation link of social App!!';
            
            // message
            $message = '
            <html>
            <body>
            <table>
            <thead style="background-color: blue;">
            <th style="padding: 15px;color: white;">Thanks For Register in Social App</th>
            </thead>
            <tbody style="background-color: lightblue;">
            <tr>
            <td style="padding: 15px;font-size: 20px;height: 200px;">
            <strong>Hello ravi,</strong><br />
                        Thanks to register with social App,Please Click the <a href="http://wintest.net23.net/Social/index.php">here</a> to active your account
            </td>
            </tr>
            </tbody>
            <tfoot style="background-color: blue;">
            <tr><td style="padding: 15px;color: white; text-align: center;">@copyright socialApp Test</td></tr>
            </tfoot>
            </table>
            </body>
            </html>

            ';
            
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            // Additional headers
            $headers .= 'Social App <info@socialApp.com>' . "\r\n";
            
            // Mail it
            //mail($to, $subject, $message, $headers);
            mail($to,'info@wintest.net23.net',"$message","from:wintest.net23.net");
echo $message;
?>