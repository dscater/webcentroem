
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/chart-morris.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 02:31:16 GMT -->
<head>
	<meta charset="utf-8" />
	<title>Gráfico</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="../../../../fonts.googleapis.com/cssff98.css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="{{url('')}}/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/animate.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/style.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{url('')}}/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE CSS STYLE ================== -->
    <link href="{{url('')}}/assets/plugins/morris/morris.css" rel="stylesheet" />
	<!-- ================== END PAGE CSS STYLE ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	
	
		
		
		
		
	
		
			
			
			
    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-6" style="display:none">
            <div class="panel panel-inverse" data-sortable-id="morris-chart-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Gráfico de cantidad de pacientes por especialidad</h4>
                </div>
                <div class="panel-body">
                    <h4 class="text-center">Audi Vehicles Sales Report in UK</h4>
                    <div id="morris-line-chart" class="height-sm"></div>
                </div>
            </div>
            <div class="panel panel-inverse" data-sortable-id="morris-chart-2">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Morris Area Chart</h4>
                </div>
                <div class="panel-body">
                    <h4 class="text-center">Quarterly Apple iOS device unit sales</h4>
                    <div id="morris-area-chart" class="height-sm"></div>
                </div>
            </div>
        </div>
        <!-- end col-6 -->
        <!-- begin col-6 -->
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="morris-chart-3">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Gráfico de cantidad de pacientes por especialidad</h4>
                </div>
                <div class="panel-body">
                    <h4 class="text-center">PACIENTE/ESPECIALIDAD</h4>
                    <div id="morris-bar-chart" class="height-sm"></div>
                </div>
            </div>
            <div class="panel panel-inverse" data-sortable-id="morris-chart-4" style="display:none">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Morris Donut Chart</h4>
                </div>
                <div class="panel-body">
                    <h4 class="text-center">Donut flavours</h4>
                    <div id="morris-donut-chart" class="height-sm"></div>
                </div>
            </div>
        </div>
        <!-- end col-6 -->
    </div>
    <!-- end row -->
    
    
    
    
    
    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
	
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{url('')}}/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="{{url('')}}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="{{url('')}}/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="{{url('')}}/assets/crossbrowserjs/respond.min.js"></script>
		<script src="{{url('')}}/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="{{url('')}}/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{url('')}}/assets/plugins/morris/raphael.min.js"></script>
    <script src="{{url('')}}/assets/plugins/morris/morris.js"></script>
	<script>
        var blue = "#348fe2", blueLight = "#5da5e8", blueDark = "#1993E4", aqua = "#49b6d6", aquaLight = "#6dc5de", aquaDark = "#3a92ab", green = "#00acac", greenLight = "#33bdbd", greenDark = "#008a8a", orange = "#f59c1a", orangeLight = "#f7b048", orangeDark = "#c47d15", dark = "#2d353c", grey = "#b6c2c9", purple = "#727cb6", purpleLight = "#8e96c5", purpleDark = "#5b6392", red = "#ff5b57";
        var handleMorrisLineChart = function () { 
            var e = [
                { period: "2011 Q3", licensed: 3407, sorned: 660 }, 
                { period: "2011 Q2", licensed: 3351, sorned: 629 }, 
                { period: "2011 Q1", licensed: 3269, sorned: 618 }, 
                { period: "2010 Q4", licensed: 3246, sorned: 661 }, 
                { period: "2009 Q4", licensed: 3171, sorned: 676 }, 
                { period: "2008 Q4", licensed: 3155, sorned: 681 }, 
                { period: "2007 Q4", licensed: 3226, sorned: 620 }, 
                { period: "2006 Q4", licensed: 3245, sorned: null }, 
                { period: "2005 Q4", licensed: 3289, sorned: null }
            ]; 
            Morris.Line(
                { element: "morris-line-chart", data: e, xkey: "period", ykeys: ["licensed", "sorned"], labels: ["Licensed", "Off the road"], resize: true, lineColors: [dark, blue] }
            ) 
        }; 
        var handleMorrisBarChart = function () { 
            Morris.Bar(
                { element: "morris-bar-chart", 
                    data: [
                        
                        @if(!empty($resultado))
                        @foreach($resultado as $key=>$value)
                        { device: "{{$value->especialidad}}", geekbench: {{$value->pacientes}} },
                        @endforeach
                        @endif
                        
                        
                    ], 
                    xkey: "device", 
                    ykeys: ["geekbench"],
                    labels: ["Paciente(s)"], 
                    barRatio: 0, 
                    xLabelAngle: 0, 
                    hideHover: "auto", 
                    resize: true, 
                    barColors: [greenDark] 
                }
            )
        }; 
        var handleMorrisAreaChart = function () { 
            Morris.Area(
                { element: "morris-area-chart", 
                    data: [
                        { period: "2010 Q1", iphone: 2666, ipad: null, itouch: 2647 }, 
                        { period: "2010 Q2", iphone: 2778, ipad: 2294, itouch: 2441 }, 
                        { period: "2010 Q3", iphone: 4912, ipad: 1969, itouch: 2501 }, 
                        { period: "2010 Q4", iphone: 3767, ipad: 3597, itouch: 5689 }, 
                        { period: "2011 Q1", iphone: 6810, ipad: 1914, itouch: 2293 }, 
                        { period: "2011 Q2", iphone: 5670, ipad: 4293, itouch: 1881 }, 
                        { period: "2011 Q3", iphone: 4820, ipad: 3795, itouch: 1588 }, 
                        { period: "2011 Q4", iphone: 15073, ipad: 5967, itouch: 5175 }, 
                        { period: "2012 Q1", iphone: 10687, ipad: 4460, itouch: 2028 }, 
                        { period: "2012 Q2", iphone: 8432, ipad: 5713, itouch: 1791 }],
                        xkey: "period",
                        ykeys: ["iphone", "ipad", "itouch"], 
                        labels: ["iPhone", "iPad", "iPod Touch"], 
                        pointSize: 2, 
                        hideHover: "auto", 
                        resize: true, 
                        lineColors: [red, orange, dark] 
                }
            ) 
        }; 
        var handleMorrisDonusChart = function () { 
            Morris.Donut(
                { 
                    element: "morris-donut-chart", 
                    data: [
                        { label: "Jam", value: 25 }, 
                        { label: "Frosted", value: 40 }, 
                        { label: "Custard", value: 25 }, 
                        { label: "Sugar", value: 10 }], 
                        formatter: function (e) { 
                            return e + "%" 
                        }, 
                        resize: true, 
                        colors: [dark, orange, red, grey] 
                }
            ) 
        }; 
        var MorrisChart = function () { 
            "use strict"; 
            return { 
                init: function () { 
                    //handleMorrisLineChart(); 
                    handleMorrisBarChart(); 
                    //handleMorrisAreaChart(); 
                    //handleMorrisDonusChart() 
                } 
            } 
        }()
    </script>
	<script src="{{url('')}}/assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			MorrisChart.init();
		});
	</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/chart-morris.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 02:31:16 GMT -->
</html>
