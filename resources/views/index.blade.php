@extends('struct')
@section ('title')
@endsection
@section('sidebar')
<li class="treeview active">
	<a href="#">
		<i class="fa fa-pie-chart"></i>
		<span>نمودار ها</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu menu-open active" style="display: block;">
		<li><a href="/"><i class="fa fa-circle-o"></i>بسته های ورودی و خروجی </a></li>
	</ul>
</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box ">
			<div class="box-header">
				<h3 class="box-title">فیلتر</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row margin">
					<div class="form-inline">
						<div class="form-group">
							<label for="Agent">نماینده :</label>
							<input type="text" class="form-control " id="Agent">
							<label for="FromDate">از تاریخ :</label>
							<input type="text" class="form-control " id="FromDate">
							<label for="ToDate">تا تاریخ :</label>
							<input type="text"  class="form-control " id="ToDate">
							<button type="submit" id="submit" class="btn btn-default ">اعمال</button>
						</div>
					</div>
				</div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col (LEFT) -->
	<div class="col-md-12">
		<!-- LINE CHART -->
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">نمودار بسته های خروجی از دفتر مرکزی</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas dir="rtl" id="lineChart" ></canvas>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->

		<!-- BAR CHART -->

		<!-- /.box -->

	</div>
	<!-- /.col (RIGHT) -->
</div>
@endsection
@section ('extensions')
<script type="text/javascript">
	//Cahrts
	function convertDate(jalaliDate) {
		try{
			jalaliDate=jalaliDate.split('/');
			var pd = new persianDate();
			pd.year = parseInt(jalaliDate[0]);
			pd.month = parseInt(jalaliDate[1]);
			pd.date = parseInt(jalaliDate[2]);
			var jdf = new jDateFunctions();
			var conDate=jdf.getGDate(pd)._toString("YYYY/MM/DD");
			conDate=conDate.split('/');
			var date = new Date(conDate[0],conDate[1],conDate[2]);
			return date;
		} catch (e) {
			alert("Enter the year correctly!");
		}
	}
	function difMonthDate(d1,d2) {
		try{
			//Diff  Func
			var months;
			months = (d2.getFullYear() - d1.getFullYear()) * 12;
			months -= d1.getMonth();
			months += d2.getMonth();
			return months <= 0 ? 0 : months;
			//End Diff Func
		} catch (e) {
			alert("Enter the year correctly!");
		}
	}
	$(document).on('click', '#submit', function(){
		var numDifMonth = difMonthDate(convertDate($('#FromDate').val()),convertDate($('#ToDate').val()));
		var EngMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var PrsMonths= ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
		var Months=[];
		var startMonth=$('#FromDate').val().split('/');
		var startYear=parseInt(startMonth[0]);
		startMonth=parseInt(startMonth[1]);
		var i = startMonth-1;
		var j=0 ;
		var myString=$("#Agent").val();
		if (myString=="") {
			alert("نمایند را مشخص کنید !");
			return false;
		}
		var agentId = myString.match(/\((.*)\)/);
		if (numDifMonth==0) { 
			alert("فاصله دو تاریخ نادرست است !");
		}
		while(j != numDifMonth+1){
			if (i==12) {
				i=0;
				startYear++;
			}
			Months.push(PrsMonths[i]+" "+startYear);	
			i++;
			j++;
		}
		myChart.options.title.display=true;
		myChart.options.title.text = $("#Agent").val();
		myChart.data.labels = Months;
		myChart.update();
	});
	var ctx = document.getElementById("lineChart").getContext('2d');
	var Months= ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
	var config = {
		type: 'line',
		data: {
			labels: Months,
			datasets: [{
				label: 'ورودی',
				backgroundColor: "#ffffff",
				borderColor: "#878787",
				data: [
				100,
				90,
				105,
				85,
				105,
				85,
				102,
				40,
				100,
				49,
				50,
				104
				],
				fill: false,
			}, {
				label: 'خروجی',
				fill: false,
				backgroundColor: "#ffffff",
				borderColor: "#00ff21",
				data: [
				102,
				70,
				90,
				102,
				90,
				102,
				103,
				100,
				50,
				110,
				105,
				80
				],
			}]
		},
		options: {
			elements: {
				line: {
                tension: 0, // disables bezier curves
            }
        },
        responsive: true,
        tooltips: {
        	mode: 'index',
        	intersect: false,
        },
        hover: {
        	mode: 'nearest',
        	intersect: true
        },
        scales: {
        	xAxes: [{
        		display: true,
        		scaleLabel: {
        			display: true,
        			labelString: 'ماه'
        		}
        	}],
        	yAxes: [{
        		display: true,

        		scaleLabel: {
        			display: true,
        			labelString: 'تعداد بسته'
        		}
        	}]
        }
    }
};
var myChart = 	window.myLine = new Chart(ctx, config);
//End Charts
//Date
$("#FromDate").persianDatepicker({
	formatDate: "YYYY/0M/0D",
	selectedBefore: !0,
        cellWidth: 33, // by px
        cellHeight: 34, // by px
        fontSize: 13 ,// by px   
        onSelect: function () { 
        	$('#ToDate').focus();
        	$('#ToDate').select();
        }
    });
$('#FromDate').keydown(function() {
  //code to not allow any changes to be made to input field
  return false;
});
$("#ToDate").persianDatepicker({
	formatDate: "YYYY/0M/0D",
	selectedBefore: !0,
        cellWidth: 33, // by px
        cellHeight: 34, // by px
        fontSize: 13 ,// by px   

    });
$('#ToDate').keydown(function() {
  //code to not allow any changes to be made to input field
  return false;
});
//End DAte
//AutoComp
var availableDeliverTags=[];
var ajx1 =$.ajax({
	method: "GET",
	url: "http://api.parschapar.local/fetch_agent",
	crossDomain: true,
	dataType: 'json',
	success: function(data){
		$.each(data['objects']['user'], function(key, value)
		{
			if (value['user_name'].substring(0,1)!="D") {
				availableDeliverTags.push({"name" :value['full_name']+" ("+value['user_no']+")","code":value['user_no']});
			}
		});
    			//availableDeliverTags= JSON.stringify(availableDeliverTags);
    			console.log(availableDeliverTags);
    		},
    		error: function(data){
    		}
    	});
var options = {
	data: availableDeliverTags,
	getValue: "name",
	list: {	
		showAnimation: {
			type: "fade", //normal|slide|fade
			time: 250,
			callback: function() {}
		},
		hideAnimation: {
			type: "slide", //normal|slide|fade
			time: 250,
			callback: function() {}
		},
		match: {
			enabled: true
		}
	},
	theme: "bootstrap"
};

$("#Agent").easyAutocomplete(options);
//End AutoComp
</script>
@endsection
