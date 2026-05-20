
<!-- saved from url=(0046)https://ashiqfarm.com/system/print-agreement/8 -->
<!doctype html>
<html lang="en">
  <head>
    <title>Print Agreement</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  </head>
  
  <style>
    @media  print{
        @page{
            size: landscape;
            margin: 0.4cm !important;
        }
    }
    th{
        padding: 0px;
    }
    
    table{width: 100%;}
    
    table, th, td {
    border: 1px solid black;
    border-top: 1px solid black !important;
    border-collapse: collapse;
    text-align: start;
    /*padding: 8px 10px !important;*/
}
.row{
    align-items: center;
    display: flex;
}

#note{margin-left: 20px;}
#note ul{list-style: none; padding-left: 0;}

#note ul li {border: 1px solid #000;padding: 4px 5px; width: 400px;}

.w42{
    width: 42%;
}
.w08{
    width: 8%;
}
hr{
    width:auto; 
    /*background-color:black !important;*/
    /* height: .5px; */
    margin-right: 10%;
    border: 0;
    border-bottom: 1px solid #000;

}
/*hr::marker{*/
/*    padding-bottom: 20px;*/
/*}*/

.demo tr td{vertical-align:bottom;}

</style>
  <body>
      
    <div class="col-12" style="border: 1.5px solid blue; padding: 20px;">
        <div class="col-12" style="border: 3px solid blue; padding: 15px;">
            <div style="width: 95%; margin: 0 auto">
                <img src="{{ asset('assets/img/bismillah.png') }}" alt="" srcset="" width="300px" style="display: block; margin: auto">
                    <div class="row p-3">
                        <div style="width: 50%; float:left">
                            <table class="table" id="schedule_fields">
                                <tbody>
                                    <tr>
                                        <th>Agreement Date</th>
                                            <td>
                                              {{ @date('d-M-Y',strtotime($agreement->agreement_date)) }}
                                            </td>
                                    </tr>
                                    <tr>
                                    <th>Agreement End Date</th>
                                <td>
                                      {{ @date('d-M-Y',strtotime($agreement->end_date)) }}
                                </td>
                                    </tr>
                                    <tr>
                                    <th>Acres</th>
                                <td>
                                    {{ @$agreement->acres }}
                                </td>
                                    </tr>
                                <tr>
                                    <th>Agreement Amount</th>
                                <td>
                                    {{ @round($agreement->agreement_amount) }}
                                </td>
                                </tr>
                                <tr>
                                    <th>Contract Name</th>
                                <td>
                                    {{ @$agreement->contract_name }}
                                </td>
                            </tr>
                        </tbody>
                        </table>
                        </div>
                        <div style="width: 50%; float: left; text-align: center">
                            <img src="{{ asset('assets/img/new_logo_2.png') }}" alt="Logo" style="width: auto; margin-top: 20px; width: 80%; margin-bottom: 20px">
                            <br>
                        </div>
                    </div>
                    <table class="table" border="0" id="schedule_fields">
                            <tbody>
                                @foreach($agreement->childSchedule AS $schedule)
                                @if($schedule->status != null)
                                <tr>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for=""><b>Due Payment Schedule</b></label></td>
                                    <td style="padding-right: 10px">{{ date('d-M-Y',strtotime($schedule->due_date)) }}</td>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for=""><b>Due Amount</b></label></td>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;">{{ round($schedule->due_amount) }}</td>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><b>Paid Date:</b>{{@date('d-M-Y',strtotime($schedule->pay_date))  }}</td>
                                </tr>
                                 @endif
                                @endforeach
                                                                                                              
                            </tbody>
                        </table>
                            <h5 style="
                                text-align: center;
                                font-size: 20px;
                            ">Upcoming Payment Schedules</h5>
                        <table class="table" border="0" id="schedule_fields">
                            <tbody>
                                @foreach($agreement->childSchedule AS $schedule)
                                @if($schedule->status == null)
                                <tr>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for=""><b>Due Payment Schedule</b></label></td>
                                    <td style="padding-right: 10px">{{ date('d-M-Y',strtotime($schedule->due_date)) }}</td>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><label for=""><b>Due Amount</b></label></td>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;">{{ round($schedule->due_amount) }}</td>
                                    <td style="min-width: 160px; padding-right:0; padding-left: 10px;"><b>Un Paid</td>
                                </tr>
                                 @endif
                                @endforeach
                                                                                                              
                            </tbody>
                        </table>                                                                                                                                                                                    </table>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="w08">
                                <label for=""><b>Any Note</b></label>
                                
                                <br>
                            </div>
                            <div class="w42"  id="note">
                               
                                       {!! @$agreement->note !!}
                                    
                                <!-- <ul><li>18 Months </li><li>Three Installment&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</li><li>Start Agreement&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;01-Aug-2022</li><li>End  Agreement&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;01-Feb-2024</li><li>Zameedar Shear&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3/4 %</li><li>First Installment&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;925,000</li><li>Second&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 457,500</li><li>Third&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 457,500</li></ul> -->
                            </div>
                            
                            <div class="w42" style="display: block; float: inline-end; border: none; margin-left:100px;">
                            <table style="border: 0 !important; direction: rtl;vertical-align:bottom" class="demo">
                                <tr style="border: 0;">
                                    <th style="border: 0 !important; padding-right: 35px !important;">Name</th>
                                    <th style="border: 0 !important; padding-right: 35px !important;">Signature</th>
                                </tr>
                                <tr style="border: 0;">
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;display:list-item; list-style-type: disc;"></td>
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;"></td>
                                </tr>
                                <tr style="border: 0;">
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;display:list-item; list-style-type: disc;"></td>
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;"></td>
                                </tr>
                                <tr style="border: 0;">
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;display:list-item; list-style-type: disc;"></td>
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;"></td>
                                </tr>
                                <tr style="border: 0;">
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;display:list-item; list-style-type: disc;"></td>
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;"></td>
                                </tr>
                                <tr style="border: 0;">
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;display:list-item; list-style-type: disc;"></td>
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;"></td>
                                </tr>
                                <tr style="border: 0;">
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;display:list-item; list-style-type: disc;"></td>
                                    <td style="border: 0 !important;"><hr style="margin-bottom: 0%;"></td>
                                </tr>
                            </table>
                            </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
            </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>