<?php

//necessita da biblioteca php-mbstring

if ((!isset($_GET["inicio"])) || (!isset($_GET["fim"]))) exit;

require_once "vendor/autoload.php";

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetHTMLHeader("<table width=\"100%\"><tr><td><b>Relatório de Arrecadação</b></td><td align=\"right\">página {PAGENO} de {nbpg}</td></tr></table>");
$mpdf->SetHTMLFooter("<table width=\"100%\"><tr><td><b>Pizzaria XYZ</b></td><td align=\"right\">{DATE d/m/Y H:i:s}</td></tr></table>");

$db = new SQLite3("pizzaria.db");
$db->exec("PRAGMA foreign_keys = ON");

$mpdf->WriteHTML("<table>");
$results1 = $db->query("select sum(tmp.preco) as total from (select comanda.data, pizza.codigo, max(case when borda.preco is null then 0 else borda.preco end+precoportamanho.preco) as preco from comanda join pizza on pizza.comanda = comanda.numero join pizzasabor on pizzasabor.pizza = pizza.codigo join sabor on pizzasabor.sabor = sabor.codigo join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho left join borda on pizza.borda = borda.codigo where date(comanda.data) between date('".$_GET["inicio"]."') and date('".$_GET["fim"]."') group by 1, 2) as tmp");
if ($row1 = $results1->fetchArray()) {
	$mpdf->WriteHTML("<tr bgcolor=\"gray\">");
	$mpdf->WriteHTML("<td colspan=\"2\"><b>".date("d/m/Y", strtotime($_GET["inicio"]))." a ".date("d/m/Y", strtotime($_GET["fim"]))."</b></td>");
	$mpdf->WriteHTML("<td align=\"right\"><b>R$ ".number_format($row1["total"], 2, ",", ".")."</b></td>");
	$mpdf->WriteHTML("</tr>");
}

$results2 = $db->query("select tmp.data, sum(tmp.preco) as total from (select comanda.data, pizza.codigo, max(case when borda.preco is null then 0 else borda.preco end+precoportamanho.preco) as preco from comanda join pizza on pizza.comanda = comanda.numero join pizzasabor on pizzasabor.pizza = pizza.codigo join sabor on pizzasabor.sabor = sabor.codigo join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho left join borda on pizza.borda = borda.codigo where date(comanda.data) between date('".$_GET["inicio"]."') and date('".$_GET["fim"]."') group by 1, 2) as tmp group by 1 order by 1 asc");
while ($row2 = $results2->fetchArray()) {
	$mpdf->WriteHTML("<tr bgcolor=\"lightgray\">");
	$mpdf->WriteHTML("<td colspan=\"2\"><b>".date("d/m/Y", strtotime($row2["data"]))."</b></td>");
	$mpdf->WriteHTML("<td align=\"right\"><b>R$ ".number_format($row2["total"], 2, ",", ".")."</b></td>");
	$mpdf->WriteHTML("</tr>");

	$count = 1;
	$results3 = $db->query("select tmp.numero as comanda, sum(tmp.preco) as total from (select comanda.numero, pizza.codigo, max(case when borda.preco is null then 0 else borda.preco end+precoportamanho.preco) as preco from comanda join pizza on pizza.comanda = comanda.numero join pizzasabor on pizzasabor.pizza = pizza.codigo join sabor on pizzasabor.sabor = sabor.codigo join precoportamanho on precoportamanho.tipo = sabor.tipo and precoportamanho.tamanho = pizza.tamanho left join borda on pizza.borda = borda.codigo where date(comanda.data) = date('".$row2["data"]."') group by 1, 2) as tmp group by 1 order by 1 asc");
	while ($row3 = $results3->fetchArray()) {
		$mpdf->WriteHTML("<tr>");
		$mpdf->WriteHTML("<td width=\"50\">".$count++."</td>");
		$mpdf->WriteHTML("<td width=\"200\">Comanda ".$row3["comanda"]."</td>");
		$mpdf->WriteHTML("<td align=\"right\" width=\"150\">R$ ".number_format($row3["total"], 2, ",", ".")."</td>");
		$mpdf->WriteHTML("</tr>");
	}
}
$mpdf->WriteHTML("</table>");

$db->close();

$mpdf->Output("relatorio.pdf", "D");
?>

