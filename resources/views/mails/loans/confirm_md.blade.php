<!DOCTYPE html>
<html>
    <head>
        <title>Loan Account Awaiting Confirmation</title>
    </head>
    <body>
        <h3>MD,</h3>
        <p>This loan account {{$loan->unique_id}} application has been reviewed and is awaiting confirmation.</p>

        <p>Loan Details:<ul>
            <li>Loan Obligor: {{$loan->user->last_name}}, {{$loan->user->first_name}} {{$loan->user->middle_name}}
            <li>Loan Amount:  <?php echo (ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($loan->amount)));?> ({{$loan->amount}}) naira</li>
            <li>Loan Account Number: {{$loan->unique_id}}</li>
            <li>Loan Type: {{$loan->type->name}}</li>
            <li>Interest Rate: {{$loan->type->rate}} per annum</li>
            <li>Loan Term: {{$loan->duration}} {{$loan->frequency}}</li>
        </ul></p>

        <p>For further details, about this loan <a href="{{config('app.url')}}/staff/loans/'{{$loan->id}}">click here</a><p>

        <p>Sincerely, <br />
        <br />
        <br />Chief Operations Officer,
        <br />{{config('app.name')}}
        </p>
    </body>
</html>