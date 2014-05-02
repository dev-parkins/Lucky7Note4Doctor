$(document).ready(function() {
	//console.log( "ready!" );
	
	$.post("user.php", {q:'1'}, function(data) {
		$("#UserPane").html(data);
	});
	
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+0D"});
	
	graph();
});
  
function RevertLeftPane(type) {
	//alert(type);
	$('form[name="'+type+'"] table input').each(function(){
		$(this).val('');
	});
	$('#AddEditPane').css('display','none');
	$('#ViewPrintPane').css('display','none');
	$('#LoadSavePane').css('display','none');
	$('#HealthMeterPane, #ActivityPane').css('display','block');
	
	$('#ButtonsPane button').removeAttr('disabled');
}

function initDate() {
	var date = new Date();
    var curr_date = date.getDate();
    var curr_month = date.getMonth('') + 1; //Months are zero based
    var curr_year = date.getFullYear();
	
	var dateVal = curr_year + "-" + curr_month + "-" + curr_date;
	$("#datepicker").val(dateVal);
	
	loadAddEditData(dateVal);
}

function AddEditForm() {
	initDate();
	$('#AddEditPane').css('display','block');
	$('#btnAddEdit').attr('disabled','disabled');
	$('#ViewPrintPane, #HealthMeterPane, #ActivityPane').css('display','none');
	$('#btnViewPrint').removeAttr('disabled');
	$('#LoadSavePane').css('display','none');
	$('#btnLoadSave').removeAttr('disabled');
}

function submitAddEdit() {
	var value = {}, type;
	
	$('#AddEditPane table input').each(function(){
		type = $(this).attr('name');
		value[type] = $(this).val();
	});
	
	$.post("addedit.php", {d: value}, function() {
		location.reload();
	});
}

function loadAddEditData(date) {
	$.post("populateAddEditform.php",{date: date}, function(data){
		var dataArr = JSON.parse(data);
		if(dataArr === null){
			//alert(dataArr);
			$('#AddEditPane table input[name!="date"]').each(function(){
				$(this).val('');
			});
		} else {
			for (var k in dataArr) {
				$('#AddEditPane table input[name="'+k+'"]').val(dataArr[k]);
			}
		}
	});
}

function ViewPrintForm() {
	$('#AddEditPane, #HealthMeterPane, #ActivityPane').css('display','none');
	$('#btnAddEdit').removeAttr('disabled');
	$('#ViewPrintPane').css('display','block');
	$('#btnViewPrint').attr('disabled','disabled');
	$('#LoadSavePane').css('display','none');
	$('#btnLoadSave').removeAttr('disabled');
}

function LoadSaveForm() {
	$('#AddEditPane, #HealthMeterPane, #ActivityPane').css('display','none');
	$('#btnAddEdit').removeAttr('disabled');
	$('#ViewPrintPane').css('display','none');
	$('#btnViewPrint').removeAttr('disabled');
	$('#LoadSavePane').css('display','block');
	$('#btnLoadSave').attr('disabled','disabled');
}

function graph() {
$('#container1').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Health Parameters'
            },
            /*subtitle: {
                text: 'Source: WorldClimate.com'
            },*/
            xAxis: {
                categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
            },
            yAxis: {
                title: {
                    text: 'Readings'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'°C';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            textShadow: '0 0 3px white, 0 0 3px white'
                        }
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
				name: 'Heart Rate',
                data: [71, 74, 72, 70, 73, 75, 73]
            }, {
                name: 'Systolic Blood Pressure',
				data: [130, 138, 140, 135, 143, 142, 139]
            }, {
                name: 'Diastolic Blood Pressure',
				data: [80, 83, 86, 82, 87, 90, 89]
            }]
        });
		
		$('#container2').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Temperature'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
            },
            yAxis: {
                title: {
                    text: 'Readings'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'°C';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            textShadow: '0 0 3px white, 0 0 3px white'
                        }
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Heart Rate',
                data: [71, 74, 72, 70, 73, 75, 73]
            }, {
                name: 'Systolic Blood Pressure',
				data: [130, 138, 140, 135, 143, 142, 139]
            }, {
                name: 'Diastolic Blood Pressure',
				data: [80, 83, 86, 82, 87, 90, 89]
            }]
        });
}