
<!DOCTYPE html>
<html>
    <head>
        <title>Introducing Your Loan Officer</title>
    </head>
    <body>
        <h3>Dear {{$loan->user->first_name}},</h3>
        <p>An account officer has been assigned to you. Your account officer would help guide you through the process of getting a loan as well as fulfilling our requirements.</p>
        <p>Your account officer's details are as follows:<ul>
            <li>Name: {{$loan->account_officer->first_name}} {{$loan->account_officer->last_name}}</li>
            <li>Email: {{$loan->account_officer->email}}</li>
            <li>Phone Number: {{$loan->account_officer->phone}}</li>
        </ul>
        </p>       
        <p>Sincerely, <br />
        <br />
        <br />Chief Operations Officer,
        <br />{{config('app.name')}}
        </p>
    </body>
</html>