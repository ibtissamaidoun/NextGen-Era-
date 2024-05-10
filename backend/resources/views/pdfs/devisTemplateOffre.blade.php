
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis Template</title>
    
    <style>
        .invoice-box {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        
        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }
        
        .rtl table {
            text-align: right;
        }
        
        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('storage/images/OrangeNext@Ai.jpg') }}"  style="width:30%; max-width:300px;">
                            </td>
                            <td>
                                Nº Devis : {{ $serie }}<br>
                                Date Demande : {{ $demande->date_demande }}<br>
                                Date D'expiration : {{ $expiration }}<br>
                            </td>
                        </tr>
                    </table>
                    		
                 
                    
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Nom et prénom du client : {{ $parent['nom'].' '.$parent->prenom }}<br>
                                E-mail : {{ $parent->email }}<br>
                                Tél : {{ $parent->telephone_portable }}<br>
                                Fixe : {{ $parent->telephone_fixe }}<br>
                            </td>
                            
                            <td>
                                Nom d’offre : {{ $offre->titre }}<br>
                                Période d’offre : {{ $offre->date_debut.' a '.$offre->date_fin }}<br>
                                Remise d’offre : {{ $offre->remise.' %' }}<br>
                                Option de paiement : {{ $optionPaiment }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            </table>
            
         <table id="tg-p6erB" class="tg">
			<thead>
				<tr style="background-color: #fe8827;">
				    <th class="tg-ul38" >ENFANT<br></th>
				    <th class="tg-ul38">ACTIVITE</th>
				    <th class="tg-ul38">SEANCES/SEMAINE</th>
				    <th class="tg-ul38">EFFICTIF ACTUEL</th>
				    <th class="tg-ul38">TARIF UNITAIRE</th>
				</tr>
			</thead>
			
			<tbody>
                @foreach ($enfantsActivites as $item)
				<tr>
					<td>{{ $item['enfant'] }}</td>
					<td>{{ $item['activite'] }}</td>
					<td>{{ $item['seances'] }}</td>
					<td>{{ $item['effictif'] }}</td>
					<td>{{ $item['tarif'] }}</td>
				</tr>
                @endforeach
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td>SOUS TOTAL</td>
					<td>{{ $prixHT }}</td>
				</tr>
                <tr>
					<td></td>
					<td></td>
					<td></td>
					<td>AVEC REMISE</td>
					<td>{{ $prixRemise }}</td>
				</tr>
                <tr>
					<td></td>
					<td></td>
					<td></td>
					<td>TVA</td>
					<td>{{ $TVA }}</td>
				</tr>
                <tr>
					<td></td>
					<td></td>
					<td></td>
					<td>TOTAL (TTC)</td>
					<td>{{ $TTC }}</td>
				</tr>
                
			</tbody>
				<script charset="utf-8">var TGSort=window.TGSort||function(n){"use strict";function r(n){return n?n.length:0}function t(n,t,e,o=0){for(e=r(n);o<e;++o)t(n[o],o)}function e(n){return n.split("").reverse().join("")}function o(n){var e=n[0];return t(n,function(n){for(;!n.startsWith(e);)e=e.substring(0,r(e)-1)}),r(e)}function u(n,r,e=[]){return t(n,function(n){r(n)&&e.push(n)}),e}var a=parseFloat;function i(n,r){return function(t){var e="";return t.replace(n,function(n,t,o){return e=t.replace(r,"")+"."+(o||"").substring(1)}),a(e)}}var s=i(/^(?:\s*)([+-]?(?:\d+)(?:,\d{3})*)(\.\d*)?$/g,/,/g),c=i(/^(?:\s*)([+-]?(?:\d+)(?:\.\d{3})*)(,\d*)?$/g,/\./g);function f(n){var t=a(n);return!isNaN(t)&&r(""+t)+1>=r(n)?t:NaN}function d(n){var e=[],o=n;return t([f,s,c],function(u){var a=[],i=[];t(n,function(n,r){r=u(n),a.push(r),r||i.push(n)}),r(i)<r(o)&&(o=i,e=a)}),r(u(o,function(n){return n==o[0]}))==r(o)?e:[]}function v(n){if("TABLE"==n.nodeName){for(var a=function(r){var e,o,u=[],a=[];return function n(r,e){e(r),t(r.childNodes,function(r){n(r,e)})}(n,function(n){"TR"==(o=n.nodeName)?(e=[],u.push(e),a.push(n)):"TD"!=o&&"TH"!=o||e.push(n)}),[u,a]}(),i=a[0],s=a[1],c=r(i),f=c>1&&r(i[0])<r(i[1])?1:0,v=f+1,p=i[f],h=r(p),l=[],g=[],N=[],m=v;m<c;++m){for(var T=0;T<h;++T){r(g)<h&&g.push([]);var C=i[m][T],L=C.textContent||C.innerText||"";g[T].push(L.trim())}N.push(m-v)}t(p,function(n,t){l[t]=0;var a=n.classList;a.add("tg-sort-header"),n.addEventListener("click",function(){var n=l[t];!function(){for(var n=0;n<h;++n){var r=p[n].classList;r.remove("tg-sort-asc"),r.remove("tg-sort-desc"),l[n]=0}}(),(n=1==n?-1:+!n)&&a.add(n>0?"tg-sort-asc":"tg-sort-desc"),l[t]=n;var i,f=g[t],m=function(r,t){return n*f[r].localeCompare(f[t])||n*(r-t)},T=function(n){var t=d(n);if(!r(t)){var u=o(n),a=o(n.map(e));t=d(n.map(function(n){return n.substring(u,r(n)-a)}))}return t}(f);(r(T)||r(T=r(u(i=f.map(Date.parse),isNaN))?[]:i))&&(m=function(r,t){var e=T[r],o=T[t],u=isNaN(e),a=isNaN(o);return u&&a?0:u?-n:a?n:e>o?n:e<o?-n:n*(r-t)});var C,L=N.slice();L.sort(m);for(var E=v;E<c;++E)(C=s[E].parentNode).removeChild(s[E]);for(E=v;E<c;++E)C.appendChild(s[v+L[E-v]])})})}}n.addEventListener("DOMContentLoaded",function(){for(var t=n.getElementsByClassName("tg"),e=0;e<r(t);++e)try{v(t[e])}catch(n){}})}(document)</script>
		  
		  
		 
          
		  
		</table>
     	

   
    
		    <style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg .tg-ul38{text-align:left;vertical-align:top;position:sticky;position:-webkit-sticky;top:-1px;will-change:transform}
		.tg .tg-0lax{text-align:left;vertical-align:top}
		.tg-sort-header::-moz-selection{background:0 0}.tg-sort-header::selection{background:0 0}.tg-sort-header{cursor:pointer}.tg-sort-header:after{content:'';float:right;margin-top:7px;border-width:0 5px 5px;border-style:solid;border-color:#404040 transparent;visibility:hidden}.tg-sort-header:hover:after{visibility:visible}.tg-sort-asc:after,.tg-sort-asc:hover:after,.tg-sort-desc:after{visibility:visible;opacity:.4}.tg-sort-desc:after{border-bottom:none;border-width:5px 5px 0}</style>
	
 </div>
</body>
</html>
