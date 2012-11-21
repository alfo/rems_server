<?php

	mysql_connect('localhost', 'user', 'password');
	mysql_select_db('my_databases');

	require_once('jpgraph/jpgraph.php');
	require_once('jpgraph/jpgraph_line.php');

	function getData() {
		$time = time() - 1440;
		$query = mysql_query("SELECT * FROM data");
		$data = array();

		while($line = mysql_fetch_assoc($query)) {
			$data[] = $line;
		}

		return $data;
	}

	function onlyData($data, $type) {
		$datas = array();
		foreach($data as $piece) {
			$datas[] = $piece[$type];
		}
		return $datas;
	}

	function onlyTime($data) {
		$timestamps = array();
		foreach ($data as $piece) {
			$timestamps[] = date('h:i:s', $piece['timestamp']);
		}
		return $timestamps;
	}

	function makeGraph() {

		$data = getData();

		$graph = new Graph(1920, 1080);
		$graph->SetScale("textlin");

		$theme_class = new UniversalTheme;

		$graph->SetTheme($theme_class);
		$graph->img->SetAntiAliasing(true);
		$graph->title->Set('Weather Station Data');
		$graph->title->SetFont(FF_VERDANA);
		$graph->title->SetColor("#F2F2F2");
		$graph->SetBox(false);
		$graph->SetBackgroundGradient('#3B3B3B','#0F0F0F', GRAD_HOR);
		$graph->SetMargin(40,20,40,30);

		$graph->yaxis->HideZeroLabel();
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);
		$graph->yaxis->SetColor("#cfcfcf");
		$graph->ygrid->SetFill(false);
		$graph->ygrid->Show();
		$graph->ygrid->SetLineStyle("solid");
		$graph->ygrid->SetColor("#3B3B3B");

		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle("solid");
		$graph->xaxis->SetTickLabels(onlyTime($data));
		$graph->xaxis->SetColor("#cfcfcf");
		$graph->xgrid->SetColor('#303030');

		$line1 = new LinePlot(onlyData($data, 'wind'));
		$graph->Add($line1);
		$line1->SetColor('#3276ED');
		$line1->SetLegend('Wind');

		$line2 = new LinePlot(onlyData($data, 'temp'));
		$graph->Add($line2);
		$line2->SetColor('#BD1122');
		$line2->SetLegend('Temperature');

		$line3 = new LinePlot(onlyData($data, 'pressure'));
		$graph->Add($line3);
		$line3->SetColor('#20E637');
		$line3->SetLegend('Pressure');

		$line4 = new LinePlot(onlyData($data, 'light'));
		$graph->Add($line4);
		$line4->SetColor('#E6D520');
		$line4->SetLegend('Light Intensity');

		$graph->legend->SetFrameWeight(30);

		$graph->Stroke();
	}


	makeGraph();

?>