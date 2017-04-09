<h3>Bank transfer information:</h3>
<dl class="dl-horizontal">
	<dt>Bank account:</dt>
	<dd>2001064718/2010</dd>
	@if (intval(Auth::user()->currency_id) === \App\Currency::CZK)
		<dt>Variable symbol:</dt>
		<dd>{{ Auth::user()->registration->variableSymbol() }}</dd>
	@else
		<dt>IBAN:</dt>
		<dd>CZ04 2010 0000 0020 0106 4718</dd>
		<dt>BIC (SWIFT):</dt>
		<dd>FIOBCZPPXXX</dd>
		<dt>Bank name:</dt>
		<dd>Fio banka</dd>
		<dt>Bank address:</dt>
		<dd>V Celnici 1028/10, 117 21 Praha 1</dd>
		<dt>Account holder name:</dt>
		<dd>Alcedo Praha</dd>
		<dt>Account holder address:</dt>
		<dd>Krymská 238/18, 10100 Praha 10</dd>
		<dt>Reference (Purpose):</dt>
		<dd>{{ Auth::user()->registration->paymentPurpose() }}</dd>
	@endif
</dl>

