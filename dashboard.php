<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<?php
$select_total='select count(id) as counts from tbl_socail_url where user_id="'.$useremail.'" and social_type="instagram"';
$fetch_total=mysql_query($select_total);
$fetch_total_num_ins=mysql_fetch_array($fetch_total);

$select_total_poc='select count(id) as counts from tbl_socail_url where user_id="'.$useremail.'" and social_type="pocket"';
$fetch_total_poc=mysql_query($select_total_poc);
$fetch_total_num_poc=mysql_fetch_array($fetch_total_poc);
?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Dashboard</h2>
						
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
                                    
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light" style="background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH8AAAB/CAMAAADxY+0hAAAAYFBMVEU6WJf///8xUpSKl7sdRY7M0eA3VpYuUJP3+Prx8/ZOZ5+HlbpGYZsQP4wrTpJ4ibJAXJnd4evo6/GvudAjSZCZpcNhdadyg68AOomPnL7V2eZofKqlr8m8w9eBkLZXbqN5kFybAAACPklEQVRoge3bUXeCIBgGYGQKaAmITldt9P//5aTaqU3MHZGP7Zzvveh096QFgvmS7BLTqorApVKtucLEvZSWSgrIEzJ6tvzyGy0ZqO7CpG6ufpNAv36CxvmlTsOPH0CXo29lIp4QaTNiaKrDH08ANaRNd/jjCWiJgh1430MVgZx2pkmrYzCYeGEu9BL3DpSmXV7T6nwa1CXDqT+D2bzTvW0LY0ohsluEMBXIGeBSHwqTTVNC+LxWhccG8ll+KGd0CF/2zawO4MvDEz2+X7dP+dh+vsBH9uXLAh/XZ2eR1O+OS3xUn9tFPqrfzU87ED59PvKj+7XvegPn0/4XfERfzl3ygHy9OPZdRCyfqvljbj5e7TCMq7Dd6/s+Dk+6jxm9ULruJHeLT8plrI0+o/6rvulrkL39zNR/JEB3Fvxfv9FQNza6d59/4kA8yX2j/5hD8f7J9wB2+Iz7rn092G6PVb6fP4Hze59fQ/GEDR5evIH51Lf0KhP7Bu78U9/Cv4Eb/n/SB5z+/qRfxPXZQ/iMz35mQ37/EO3bexR0P81mfi6+xeNnYprt7r/VPnEx263/0UcfffTRRx/9/+Jvd/+Nv+zusb7/PRq1m8Ru96ARf0i38/jFG58k0oM+Kdbf6KOPPvroo48++uijjz766KOPPvroo/9P/OAGVpBfhfffQnyqwvt/Ib5sw/uPAb7rPwb3PwN81/8M7r+u96/919D+72r/1v8N7T+v9O/958D+9yqfSn7vf2dB/fc1/r3//gl2kSijufXbOQAAAABJRU5ErkJggg=='); background-size: cover">
												<div class="stat-panel text-center">
													<div class="stat-panel-number h1 ">0</div>
													<div class="stat-panel-title text-uppercase">Total Pictures</div>
												</div>
											</div>
											<a href="#" class="block-anchor panel-footer">Facebook<i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
                                    
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light" style="background: url('data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAHQAdAMBEQACEQEDEQH/xAAcAAACAwEBAQEAAAAAAAAAAAAABwMEBgUCAQj/xAA/EAABAwMABgUJBgQHAAAAAAABAAIDBAURBgcSITFBE1FhcbEiNDVzdIGRssEVIzJSodEUQmJyFhckQ1OS8P/EABsBAQACAwEBAAAAAAAAAAAAAAAEBgIDBQEH/8QANREAAgECAwUECQQDAQAAAAAAAAECAwQFETESITJxsQZBUcETFCI0YZGh0eEjM4HwQmLxFf/aAAwDAQACEQMRAD8Aa+kmkFJYaMS1GXyv3RQt4vP0C11Kigt5NsrGpdz2Y7ktWK67aW3i5ucH1Rp4jnEVOSwAdpzkqDKvOXeW+3wq1oaRzfi9/wCPocRznPcXPJc48STklajoJJbkfEPQQAgBACAEAIAQAgJYKqopnh9NUTQuHAxyFvgvU2tDXOlCaylFPmbHRjTqqp6hlPeX9PTO3dOR5cfaesKRSuHnlI4d/glOcXOhuku7uGex7Xsa5rgWkZBHNTipPc8mJTTG4uuekNXIXEsid0MYzuAaSPHK5taTlNl9wy3VC1iu973/ACcVajoAgBACAEAIAQAgBACAEAIA70A3NX9f/E6M07ZTl1OTDvPJvD9CFPozzgUjGbfYu5Nd+/5iprDmrnJ4mV+f+xUF6l0p7qceS6IhXhmCAEAYJ3AEnkBzQ8NNaNB7vcmtlexlHC7eHT52iP7ePgt8LecjlXONW1B5L2n8Puaek1b29gH8VW1EzueyAwfXxW9Wse9nHqdoazfsQSLv+X9ixjYqM9fSle+rQNH/ALt3nqvkUa3VvQvb/o6yeF39YDx9Fi7WPcyRS7Q1l+5FPluMletEbtZ2GWSJtRTjjLBk4HWRxCjzozgdq1xW2uXsp5PwZwFqOmwQAgBAMXV1vsk3tLvlapdDgKvjXvC5ebF/V+dT+tf4lRXqWWnwR5LoRLwzBASU8EtTOyCnYXyyO2WtbxJXqTe5GE5xpxcpPJIbGimiFNZmNqaprJq8je/i2Psb+6n0qKhvepTMRxWpdPYhuh15/Y71zulFaqYz187YWcs8XHqA5rbKais2c6hb1biWzTWbMZW6yoGkigoJJWj+aZwYD7hkqPK6S4Ud2l2dm1nVmly3lJusur2htWyDHPEp/ZYK6fgSH2dpZbqj+R2LXrDtlVK2OuilpHHdtnyme8jePeFsjcxe5kC4wGvTW1Te19GbFkjJow6NwexwyCN4IUk4jTi8nqjA6caHM6KW52mINe0F88DeDhzc0dfYolah/lEseE4s1JUK7zXc35i63cRw5KGWkEAIBi6uvQk3tLvlapVDgKxjXvC5ebF/V+dT+tf4lRnqWSnwR5LoRLwzBAMjVlZGMpzeJ2ZllyyDI4NBwT7yPgpttTyW0yq49eNz9Xi9y3vmarSO8Q2O2SVk3lOHkxx/nceA/wDclvqTUI7TONZ2k7qsqcf5+CExdblVXWsfWV0hc88Opo6h1Bc2cnJ5svtvb07en6Omsl/dSamsV2q4RPTW6pkiPB7WbiipyazSNdS9tqctmdRJlCWKSGR0czHMkacOa4YI9yxay1JEZRktqLzR570MjZau9IZKK4MtdQ/NLUHEef8Abf8AsfFSbeq09lnCxqwVWk68eKOvxX4GmRlTinic06tAtN9k6IYp6n72MdWfxD4+K51eGzIvOEXfrFutrijufkZ1aTqAgGLq69CTe0u+VqlUOArGNe8Ll5sX9X51P61/iVGepZKfBHkuhEvDM+sbtuaxv4nEAd5Q8byWY/KCmZRUUFNGAGxMDBjsC60Vksj5vWqOpUdR97FnrOuD6i+R0bXfdUsYJH9Tt/hhQrmWcsvAtuA0FC3dV6yf0RV0Assd3u7palu3T0oD3NPBzjwH6ErGhT2pZvuNuM3kraiow4pdBvBrWgANAA4ALoFJz7xda16KFj6CtY0NlkLonkD8QAyM+HvUO6WjLP2dqyanSeiyYv1ELMeo5nU8jZ252oiHjHWDlerUxlFTTi+/d8z9AxO2o2uPMArqrQ+atZNow2tiAG3UFRzZUGM9zmk+LQo10vZTLD2dnlWnDxWfya+4tVCLWCAYurr0JN7S75WqVQ4CsY17wuXmxf1fnU/rX+JUZ6lkp8EeS6ES8MyaiIbXUridzZ4ye4OC9jqjXV/blyfQ/QGV1j5sJXTba/xVcdv/AJBju2Rhc2t+4y+YVl6lTy/u81mqbZ/gbj+bpm57tnd9VItdGcXtFn6Sny8zfFSiuiz1q1okuFHRtIPRRmRw7XcP0ChXT9pItfZ6llTnV8X0MKopYj6yPpntiAyZHBg9+5FqeOWym/A/QcI2YmN6gAustD5o3m2zE62JALPQxji6rzjsDHfuFGuuFHf7Ox/XnL/XzQsVCLaCAYurr0JN7S75WqVQ4CsY17wuXmxf1fnU/rX+JUZ6lkp8EeS6ES8MwzjeOKAemj9xZdbPS1kZzts8rscNxB966kJbUUz53eUHb15U33GH1nWR7Klt5hbmN7Wxz45O4NPvzj4KNc03ntIsGA3icHby1W9eZ41Uvl+0a6Nu+ExNL+/O76ry11Zl2ijD0UH35voM13BTSqCM0mrvtG/11TnLXSlrP7W7h4Ll1ZbU2z6DYUfQ20IfDrvOYsCYdrQ2hNw0koo8ZZG/pX9jW7/HC2UY7U0c/FKyo2k5d73fyx2N4b10yhCz1rVYkuFHRtO+KN0jh1FxGPBQrp70i19nqTVOdR9+75f9MKopYgQDF1dehJvaXfK1SqHAVjGveFy82L+r86n9a/xKjPUslPgjyXQiXhmCA0eiGlElgndHM0yUMpy9jfxMP5h+y3UqzhuehysTw1XkVKO6S+qO/p7pJQXGxRU1uqmzGeRrnhoOWtG/f1b8LdXqxlHJHNwfDq1G5c6scslu/ku6rKTorTU1bhg1E2B3NH7krK1jlFs0doK21XjT8F1NpO0vhe1pwSCAepSTgp5NMQFVBJS1MtPO0tlicWuB6wuS1k8j6TTqRqQU46M8AEuDWglxOAAMknsXhk9yGzoBo66z0TqmrZs1lQBlv5G8h38yp9vS2FmymYxfq5qbEH7MfqzTVdRFSU0tRO8MijaXOceQC3t5LM5NOEqk1COrEZerg663aprn5++floPJvAD4LlzltybPoVpbq3oxpLuKSxJAIBi6uvQk3tLvlapVDgKxjXvC5ebF/V+dT+tf4lRnqWSnwR5LoRLwzBACA+EgAkoFqPDROjNDo7QQuGH9CHv73bz4rp0o7MEj5/iNX0t1Ofx6F2ouFLT1VPSzShk1RtdE1382MZ8Vm5JPJkeFGc4SnFblr/JRvGjdpvLtuvpg6QbukY4td8QsJ0oze9Ei1xC5tllTlu8NUebTovZ7RIJaOkaJRwkkcXuHcTwSNKEND24xK6uVs1JbvBbl9DrTzRwROlme2NjRlznHACzby1IUYuTUYrNis030s+13Ght7iKJp8t+MGUjh7lBrVtr2VoXDCsK9WXpavH0/JkFHO4CAEAxdXXoSb2l3ytUqhwFYxr3hcvNi/q/Op/Wv8Soz1LJT4I8l0Il4ZggBAWrXSmtuVLSjf00rWEdhO9ZQWckjTcVVSpSqPuQ/GgNYGt3ADAXVPnDee8U+sytM2kTIGu3UsQAIPBx3n6KBcyznl4FxwGjsWrk/8n03ENs07vNDE2OR0VU1u4dODtfEcV5G4nFZGy4wS1rPaXs8i5NrHujm4jpKSM/m8o/VZO6k+40Ls/bp75N/Izl1vlyu7819U+RvKMbmD3BaZ1JT1Z1bayoWy/Tjl1OcsCUCAEAIBi6uvQk3tLvlapVDgKxjXvC5ebF/V+dz+tf4lRnqWSnwR5LoRLwzBACA0Wr6ETaV0mQCI2vkwexpH1W63WdRHLxmezZT+OS+o4nvbHE57zhrQSSeQXRbyKPFNvJCGvFb9o3SqrDn76Vzm93L9MLlTe1Js+i2tH0FCFLwX/SosTeCAEAIAQAgBAMXV16Dm9pd8rVKocBV8a94XLzZhrxTPpLtWQPGHMnePdk4/TCjzWzJosNtUVShCa70imsTeCAEBp9W7g3SuHPOGQD4Bb7f9w5GOLOyfNGr1kXwUVu+zoH4qKoeXj+WPn8eHxUi4qZLZRxsDs/S1fTSW6PX8CtUAuAIAQAgBACAEAIBnauaN50edIcgSVD3DtGAPoplCLcCo45VXrWXgl5lHWTo9I6f7ZpGFzS0NqGtH4ccH+APcF5cUnxokYHfxUfV6jy8PsL9RCzAgBAdCw3I2i7U9eGbYhLsszjILSPqs4S2ZZkW8t/WaEqTeWf3zILlXT3KumrKp21LK7JA4AcgOwLGUnJ5s2W9CFvSVKC3IrLw3AgBACAEAIAQF6zWqqvFcylo4yST5b8box1lZQg5vJEa6uqdtTc5v8jttNBFbLbT0UGdiFgbk8XHmT2niunCOzHIoNxWlcVZVZastPa0tILQQeIIWRp0MVpJodaHRvqoI30zzlxbAQGk9xBCi1qMNUdzD8Xut0JPPmLOZgjlewZIGRvUIttOW1HNkaGwEAIAQAgBACAEAIDVaGaO0V5eXVrpsNz5LHAA/pn9Vvo04z1OPil/VtV+ml/foNG2W2itkBhoKaKBmcnYbvcesnmVOjCMdEVCvcVa8tqrLNlxZGk//9k=');
background-size: cover;">
												<div class="stat-panel text-center">
													<div class="stat-panel-number h1 ">0</div>
													<div class="stat-panel-title text-uppercase">Total Pictures</div>
												</div>
											</div>
											<a href="#" class="block-anchor panel-footer text-center">Pinterest<i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
                                        
											<div class="panel-body bk-info text-light" style="background: url('https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcRF6l13EExmuwwVQ1hRtc3uBgVycS4nsxRSiwgtc2vl0axP8GgcdQ');
background-size: cover;">
												<div class="stat-panel text-center">
													<div class="stat-panel-number h1 "><?php echo $fetch_total_num_poc['counts'];?></div>
													<div class="stat-panel-title text-uppercase">Total Pictures</div>
												</div>
											</div>
											<a href="pocket/" class="block-anchor panel-footer text-center">Pocket &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-warning text-light" style="background: url('data:image/jpeg;base64,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');
background-size: cover;">
												<div class="stat-panel text-center" >
													<div class="stat-panel-number h1 "><?php echo $fetch_total_num_ins['counts'];?></div>
													<div class="stat-panel-title text-uppercase">Total Pictures</div>
												</div>
											</div>
											<a href="ins/instagram/success.php" class="block-anchor panel-footer text-center">Instagram &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>

				</div>	
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	
	<script>
		
	window.onload = function(){
    
		// Line chart from swirlData for dashReport
		var ctx = document.getElementById("dashReport").getContext("2d");
		window.myLine = new Chart(ctx).Line(swirlData, {
			responsive: true,
			scaleShowVerticalLines: false,
			scaleBeginAtZero : true,
			multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
		}); 
		
		// Pie Chart from doughutData
		var doctx = document.getElementById("chart-area3").getContext("2d");
		window.myDoughnut = new Chart(doctx).Pie(doughnutData, {responsive : true});

		// Dougnut Chart from doughnutData
		var doctx = document.getElementById("chart-area4").getContext("2d");
		window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});

	}
	</script>

</body>

</html>

