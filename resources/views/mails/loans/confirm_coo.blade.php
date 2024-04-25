<!DOCTYPE html>
<html>
    <head>
        <title>Loan Account Awaiting Disbursement</title>
    </head>
    <body>
        <h3>Dear Disbursement Unit,</h3>
        <p>A new loan application has been confirmed and awaiting disbursement. </p>

        <p>Please find the loan details below:<ul>
            <li>Loan Obligor: {{$loan->user->last_name}}, {{$loan->user->first_name}} {{$loan->user->middle_name}}
            <li>Loan Amount:  <?php echo (ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($loan->amount)));?> ({{$loan->amount}}) naira</li>
            <li>Loan Account Number: {{$loan->unique_id}}</li>
            <li>Loan Type: {{$loan->type->name}}</li>
            <li>Interest Rate: {{$loan->type->rate}} per annum</li>
            <li>Loan Term: {{$loan->duration}} {{$loan->frequency}}</li>
        </ul></p>
        <p>You can follow up with the ERM if you need further details.</p>

        <p>Sincerely, <br />
        <br />
        <br />Chief Operations Officer,
        <br />{{config('app.name')}}
        </p>
    </body>
</html>