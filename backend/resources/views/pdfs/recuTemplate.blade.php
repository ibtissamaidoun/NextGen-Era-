<?php 
use Carbon\Carbon;
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Devis Template</title>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top" >
                <td class='titre' style="text-transform:uppercase;">
                    REÇU
                </td>
                <td rowspan="2" style="text-align: right;  vertical-align: top;">
                    <img src="{{ $image }}"  class='image'>
                </td>
            </tr>
            <tr>
                <td class='dates' style="text-transform:uppercase;">
                    Nº REÇU : {{ $serie }}<br>
                    DATE PAIEMENT : {{ $date_paiement }}<br><br>
                    @if ($traite < $total_traite)
                    DATE PROCHAINE DE PAIMENT : {{ $date_prochaine_paiement }} *<br>
                    @endif
                </td>
            </tr>
            </tr>
            <tr>
                <td  class='info'>
                    Client : {{ $parent['nom'].' '.$parent->prenom }}<br>
                    E-mail : {{ $parent->email }}<br>
                    Tél : {{ $parent->telephone_portable }}<br>
                    Fixe : {{ $parent->telephone_fixe }}<br>
                </td>
                
                <td  class='info' style='text-align: left;'>
                    Option de paiement : {{ $optionPaiment }}<br>
                </td>
            </tr>
            
        </table>
            
        <table class="tg">
            <colgroup>
                <col span="4">
                <col span="1">
            </colgroup>
			<thead>
				<tr>
				    <th class='prix'>QTE</th>
				    <th class='prix'>ACTIVITE</th>
				    <th class='prix'>TARIF UNITAIRE</th>
				    <th class='prix'>TARIF</th>
				</tr>
			</thead>
			
			<tbody>
                @foreach ($items as $item)
				<tr>
					<td class='td'>{{ $item['qte'] }}</td>
					<td class='td'>{{ $item['activite'] }}</td>
					<td class='td'>{{ $item['tarif'] }}</td>
					<td class='tdPrix' class='dataPrix'>{{ $item['tarif']*$item['qte'] }} DH</td>
				</tr>
                @endforeach
                
				<tr>
					<td colspan="2" rowspan="3" class='hidden'></td>
					<td class="prix">TOTAL</td>
					<td class="tdPrix">{{ $TTC }} DH</td>
				</tr>
                <tr>
					<td class="prix">TRAITE</td>
					<td class="tdPrix">{{ $traite }} / {{ $total_traite }}</td>
				</tr>
                <tr>
					<td class="prix">COUT DE TRAITE</td>
					<td class="prixBottomRight">{{ $tarif_traite }} DH</td>
				</tr>
                
			</tbody>
		</table>
            @if ($traite < $total_traite)
            <div style='padding-bottom: 25px; padding-top: 75px;'>
                * : Votre Demande sera annulée si vous passer la date limite (48 heures) après la date de paiement déjà motionnée au début sans payé.</p>
            </div>
            @endif
        <div style='padding-bottom: 25px; padding-top: 30px'>
            <p class='text'>Reçu établi le : {{ Carbon::now('Africa/Casablanca')->addHours(1)->toDateTimeString() }}</p>
            <p class='merci'>MERCI POUR VOTRE CONFIANCE !</p>
        </div>
        

     	

   
    
		<style type="text/css">
                @font-face {
                font-family: 'Ford Antenna';
                src: url({{ storage_path('fonts/Ford Antenna TTF/FordAntenna-Regular.ttf')}}) format('truetype');
                }
                @font-face {
                font-family: 'Ford Antenna SemiBold';
                src: url({{ storage_path('fonts/Ford Antenna TTF/FordAntenna-Semibold.ttf')}}) format('truetype');
                }
                @font-face {
                font-family: 'Ford Antenna Black';
                src: url({{ storage_path('fonts/Ford Antenna TTF/FordAntenna-Black.ttf')}}) format('truetype');
                }
                .description{ font-family: Ford Antenna SemiBold ;font-size: 25px;padding-top: 100px}
                .merci{color: #10278a;font-family: Ford Antenna SemiBold ;font-size: 16px;}
                .dates{color: #10278a; font-family: Ford Antenna SemiBold ;font-size: 15px;padding-bottom:30px;line-height: 1.6;}
                .titre{color: #10278a; font-family: Ford Antenna Black ;font-size: 50px;padding-bottom:35px;}
                .info{font-family: Ford Antenna;font-size: 14px;padding-bottom: 35px;line-height: 1.8;vertical-align:text-top; }
                .image{width:46%; max-width:300px;}
                .first{border-inline-start-color: black;}
                .tg  {text-align: left; font-family: Ford Antenna;font-size: smaller;padding:5px 10px;border-collapse:collapse;}
                .text{text-align: left; font-family: Ford Antenna;}
                .tg .hidden{border:transparent;}
                .tg .td{border:ridge black 1px;padding:5px 10px;}
                .tg .tdPrix{border:ridge black 1px;padding:5px 10px; text-align: right;background-color: #f2f2f2}
                .tg .prixBottomRight{border:ridge black 1px;padding:5px 10px;text-align: right; font-family: Ford Antenna SemiBold;color: white;background-color: #FF6C22; font-size: 15px}
                .tg .dataPrix{border:ridge black 1px;text-align-last: right;}
                .tg .prix{border:ridge black 1px;padding: 5px 10px;font-family: Ford Antenna SemiBold;color: white;background-color: #FF6C22; }
                .invoice-box {
                    padding: 30px;
                    line-height: 24px;
                    color: #373636;
                }
                
                .invoice-box table {
                    width: 100%;
                }
                
        </style>
	
 </div>
</body>
</html>
