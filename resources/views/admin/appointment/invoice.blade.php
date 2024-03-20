@extends('admin.layouts.app')
@section('wrapper')

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
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

			/* .invoice-box table tr td:nth-child(2) {
				text-align: right;
			} */

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

			.invoice-box table tr.item td {
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
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            .service td  {
                border:1px solid black;
                 border-collapse: collapse;
             }
             .service th  {
                border:1px solid black;
                 border-collapse: collapse;
             }
		</style>
<div class="content">
<div class="main">
    <div>
        <h5>{{ $single_heading }} Invoice</h5>
    </div>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="">
					<td colspan="2">
						<table>
							<tr>
								<td style="width: 50%;">
                                    <table>
                                        <tr>
                                            <td>
                                                <b>Name:</b> {{ $appointment->userData->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <b> Email :</b> {{ $appointment->userData->email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b> Number :</b> {{ $appointment->userData->mobile_number }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>

								<td style="width: 50%;">
									<table>
                                        <tr>
                                            <td style="text-align: end;">
                                                <b>Shop Number:</b> {{ $appointment->clientData->owner_phonenumber }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">
                                                <b>Shop Name: </b>{{ $appointment->clientData->outlet_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: end;">
                                            <b>Shop Address:</b>  {{ $appointment->clientData->outlet_address }}
                                            </td>
                                        </tr>
                                    </table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
            <table class="service">
                <thead>
                    <tr>
                    <th>S.No. </th>
                    <th>Services</th>
                    <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; ?>
          @foreach($appointmentDetails as $appointmentDetail)
          <tr>
          <td class="py-3"><?php echo $no; ?></td>
             <td class="py-3">{{$appointmentDetail->clientServePriceData->services}}</td>
             <td class="py-3">₹ {{$appointmentDetail->clientServePriceData->price}}</td>
             </tr>
             <?php $no++; ?>
                    <?php $no++; ?>
          @endforeach
                </tbody>
                <tfoot>
             <tr>
                <td class="text-end" colspan="2">Sub Total</td>
                <td>₹ {{ $appointment->sub_total }}</td>
                </tr>
                <tr>
                <td class="text-end" colspan="2">Tax</td>
                <td>{{ $appointment->tax }}%</td>
                </tr>
                <tr>
                <td class="text-end" colspan="2">Total</td>
                <td>₹ {{ $appointment->price }}</td>
                </tr>
         </tfoot>
            </table>
		</div>
		</div>
@endsection