<!DOCTYPE html>
<html>
    <head>
        <title>New Loan Account Confirmed</title>
    </head>
    <body>
        <h3>Dear {{$loan->account_officer->first_name}},</h3>
        <p>Your loan account {{$loan->unique_id}} application has been confirmed and is now ready for disbursement.</p>

        <p>Loan Details:<ul>
            <li>Loan Obligor: {{$loan->user->last_name}}, {{$loan->user->first_name}} {{$loan->user->middle_name}}
            <li>Loan Amount:  <?php echo (ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($loan->amount)));?> ({{$loan->amount}}) naira</li>
            <li>Loan Account Number: {{$loan->unique_id}}</li>
            <li>Loan Type: {{$loan->type->name}}</li>
            <li>Interest Rate: {{$loan->type->rate}} per annum</li>
            <li>Loan Term: {{$loan->duration}} {{$loan->frequency}}</li>
        </ul></p>

        <p>Sincerely, <br />
        <br />
        <br />Chief Operations Officer,
        <br />{{config('app.name')}}
        </p>
    </body>
</html>