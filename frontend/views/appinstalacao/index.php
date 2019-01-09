<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppinstalacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instalação';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
//'https://api.mlab.com/api/1/databases/tecsdb/collections/tecs?apiKey=FadNlSlxW08n39zzET_9idXHX-6AyL3w'
//'https://pacific-forest-15813.herokuapp.com/tec2'
var allData;
		
		//heroku
		/*
		var pusher = new Pusher('b193b50aea652a0401ad', {
			  cluster: 'mt1',
			  forceTLS: true
			});
*/
		//Teste local
		var pusher = new Pusher('93a1a948489cdb5415f4', {
			  cluster: 'us2',
			  forceTLS: true
			});
		


        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            var inst = JSON.stringify(data);
			
            
            var ping;
            var aux = true;
            switch (data.estado) {
                case "AC": ping = $('#state-ac'); break;
                case "AL": ping = $('#state-al'); break;
                case "AP": ping = $('#state-ap'); break;
                case "AM": ping = $('#state-am'); break;
                case "BA": ping = $('#state-ba'); break;
                case "CE": ping = $('#state-ce'); break;
                case "DF": ping = $('#state-df'); break;
                case "ES": ping = $('#state-es'); break;
                case "GO": ping = $('#state-go'); break;
                case "MA": ping = $('#state-ma'); break;
                case "MT": ping = $('#state-mt'); break;
                case "MS": ping = $('#state-ms'); break;
                case "MG": ping = $('#state-mg'); break;
                case "PA": ping = $('#state-pa'); break;
                case "PB": ping = $('#state-pb'); break;
                case "PR": ping = $('#state-pr'); break;
                case "PE": ping = $('#state-pe'); break;
                case "PI": ping = $('#state-pi'); break;
                case "RJ": ping = $('#state-rj'); break;
                case "RN": ping = $('#state-rn'); break;
                case "RS": ping = $('#state-rs'); break;
                case "RO": ping = $('#state-ro'); break;
                case "RR": ping = $('#state-rr'); break;
                case "SC": ping = $('#state-sc'); break;
                case "SP": ping = $('#state-sp'); break;
                case "SE": ping = $('#state-se'); break;
                case "TO": ping = $('#state-to'); break;
                default:
                    ping = $('#state-to');
                    aux = false;
                    break;
            }
            if (aux) {
				
                allData.push(data);
			
				addHist(data);

                
                //document.getElementById("cidade").innerHTML = '- ' + data.cidade;
                //document.getElementById("inst").innerHTML = data.instalador;
                //document.getElementById("cli").innerHTML = data.nome;
                ping.removeClass('mapa-svg-estados-active');
			
				ping.siblings().removeClass('mapa-svg-estados-active');
				
                ping.addClass('mapa-svg-estados-active');
				console.log(ping)
				console.log(ping.attr('id'))
				$('.class-select').val(ping.attr('id')).trigger('change');

                //ping.val($('#state-am').attr('id')).trigger('change');
                //$('#tabelaInfo').text(inst);
                //moveUpestado(ping);
                reDraw();

            }
        });
		
		function addZero(i) {
			if (i < 10) {
				i = "0" + i;
			}
			return i;
		}
		
		function dataAtualFormatada(date){
			var data = new Date(date),
			dia  = data.getDate().toString().padStart(2, '0'),
			mes  = (data.getMonth()+1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
			ano  = data.getFullYear(),
			h = addZero(data.getHours()+4),
			m = addZero(data.getMinutes()),
			s = addZero(data.getSeconds());
			
			return dia+"/"+mes+"/"+ano + " - "+h + ":" + m + ":" + s;
		}
		
		function addHist(data){
			var last = allData.length;
			var txt = "<div class='roww'>";
			txt += "<div class='coluna'>" + (last) + "</div>";
		   
			txt += "<div class='coluna2' style='border: 1px solid black; '>";
			//txt += "Data: <span id='data'>"+ dataAtualFormatada(allData[last-i].data["Sdate"]) +"</span>"
			txt += "Data:<span id='data'>"+ dataAtualFormatada(allData[last-1].data) +"</span>"
			txt += "<br>ASC:<span id='asc'>"+ allData[last-1].instalador_info.asc +"</span>";
			txt += "<br>Instalador:<span id='inst'>"+ allData[last-1].instalador +"</span>";
			txt += "<br>Cliente:<span id='cli'>"+ allData[last-1].nome +"</span></div> ";
			txt += "</div>"
			$(".hist").prepend(txt);
			if ($('.roww').length > 10) {
				$('.hist').children().last().remove();
			}
		}
		
		function populateHist() {
			var last = allData.length;
			var i;
			
			
			for (i = 1; i < 12 && i < last; i++) {
				var txt = "<div class='roww'>";
				txt += "<div class='coluna'>" + (last-i+1)+ "</div>";
			   
				txt += "<div class='coluna2' style='border: 1px solid black; '>";
				//txt += "Data: <span id='data'>"+ dataAtualFormatada(allData[last-i].data["Sdate"]) +"</span>"
				txt += "Data:           <span id='data'>"+ dataAtualFormatada(allData[last-i].data) +"</span>"
				txt += "<br>ASC:        <span id='asc'>"+ allData[last-i].instalador_info.asc +"</span>";
				txt += "<br>Instalador: <span id='inst'>"+ allData[last-i].instalador +"</span>";
				txt += "<br>Cliente:     <span id='cli'>"+ allData[last-i].nome +"</span></div> ";
				txt += "</div>"
				$(".hist").append(txt);
				
				
			}
        }
		
		function populateHist2() {
			var last = allData.length;
			var i;
			
			var txt = "<table style='overflow-x:auto;' id='tabelaMapa'>";
			for (i = 1; i < 12 && i < last; i++) {
				txt += "<tr><th rowspan='4'>"+(last-i+1)+"</th>";
				txt += "<td>Data</td>";
				txt += "<td>"+dataAtualFormatada(allData[last-i].data)+"</td></tr>";
				txt += "<tr><td>ASC</td>";
				txt += "<td>"+allData[last-i].instalador_info.asc+"</td></tr>";
				txt += "<tr><td>Responsável</td>";
				txt += "<td>"+allData[last-i].instalador+"</td></tr>";
				txt += "<tr><td>Cliente</td>";
				txt += "<td style='width:100%'>"+allData[last-i].nome+"</td></tr>";
			}
			txt += "</table>";
			$(".hist").html(txt);
        }
		
		function populateHistAll() {
			var last = allData.length;
			var i;
			var txt = "<div class='container'><h2>Histórico de instalações</h2><div class='panel-group' id='accordion'>";
			for (i = 1; i < last; i++) {
				var collapse = "collapse"+i;
				var accordion = "accordion"+i;
				var clienteAccordion = "clienteAccordion"+i;
				var tecnicoAccordion = "tecnicoAccordion"+i;
				var clienteDados = "clienteDados"+i;
				var tecnicoDados = "tecnicosDados"+i;
				var passosDados = "passosDados"+i;
				
				txt += "<div class='panel panel-default'>";
				txt += "<div class='panel-heading'>";
				txt += "<h4 class='panel-title'>";
				txt += "<a data-toggle='collapse' data-parent='#accordion' href='#"+collapse+"'>"+allData[last-i].cidade +" - "+dataAtualFormatada(allData[last-1].data)+"</a>";
				txt += "</h4></div><div id='"+collapse+"' class='panel-collapse collapse'>";
				txt += "<div class='panel-body'>";
				/*
				txt += "<div class='dados'>";
				
				txt += "Modelo: "+allData[last-i].modelo;
				
				txt += "</div>";
				*/
				//txt += "<div><h2>"+allData[last-i].cidade+"</h2><ul>";
				txt += "<div><ul>";
				txt += "<li class='listaInfo'><p class='alignleft'>Modelo: <p class='aligncenter'>"+allData[last-i].modelo+"</p></p></li>";
				txt += "<li class='listaInfo'><p class='alignleft'>Serial: <p class='aligncenter'>"+allData[last-i].serial+"</p></p></li>";
				txt += "<li class='listaInfo'><p class='alignleft'>Numero: <p class='aligncenter'>"+allData[last-i].numero+"</p></p></li>";
				
				txt += "</ul></div>";
				
				 
				var txt2 = "<div class='container-fluid'><div class='panel-group2'>";
				txt2 += "<div class='panel panel-default'>";
				txt2 += "<div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse'  href='#"+clienteDados+"'>Dados Cliente</a></h4></div>";
				txt2 += "<div id='"+clienteDados+"' class='panel-collapse collapse'>";
				txt2 += "<div class='panel-body'>";
				
				//txt2 += allData[last-i].nome;
				
				txt2 += "<table style='overflow-x:auto;' class='noback2'>";
				txt2 += "<tr>";
				txt2 += "<td>Cliente</td>";
				txt2 += "<td>"+allData[last-i].nome+"</td></tr>";
				
				txt2 += "<tr><td>Telefone</td>";
				txt2 += "<td>"+allData[last-i].telefone+"</td></tr>";
				
				txt2 += "<tr><td>CPF</td>";
				txt2 += "<td>"+allData[last-i].cpf+"</td></tr>";
	
				txt2 += "<tr><td>Cidade</td>";
				txt2 += "<td>"+allData[last-i].cidade+" - "+ allData[last-i].instalador_info.estado+"</td></tr>";
				
				txt2 += "<tr><td>CEP</td>";
				txt2 += "<td style='width:100%'>"+allData[last-i].cep+"</td></tr>";
				txt2 += "</table>";
				
				txt2 += "</div></div></div></div></div>";
				
				var txt4 = "<div class='container-fluid'><div class='panel-group2'>";
				txt4 += "<div class='panel panel-default'>";
				txt4 += "<div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#"+tecnicoDados+"'>Dados Instalador</a></h4></div>";
				txt4 += "<div id='"+tecnicoDados+"' class='panel-collapse collapse'>";
				txt4 += "<div class='panel-body'>";
				
				txt4 += "<table style='overflow-x:auto;' class='noback2'>";
				txt4 += "<tr>";
				txt4 += "<td>Responsável</td>";
				txt4 += "<td>"+allData[last-i].instalador_info.nome+"</td></tr>";
				
				txt4 += "<tr><td>Telefone</td>";
				txt4 += "<td>"+allData[last-i].instalador_info.telefone+"</td></tr>";
				
				txt4 += "<td>ASC</td>";
				txt4 += "<td>"+allData[last-i].instalador_info.asc+"</td></tr>";
				
				txt4 += "<tr><td>CPF</td>";
				txt4 += "<td>"+allData[last-i].instalador_info.cpf+"</td></tr>";
	
				txt4 += "<tr><td>Cidade</td>";
				txt4 += "<td>"+allData[last-i].instalador_info.cidade+" - "+ allData[last-i].instalador_info.estado+"</td></tr>";
				
				txt4 += "<tr><td>CEP</td>";
				txt4 += "<td style='width:100%'>"+allData[last-i].cep+"</td></tr>";
				txt4 += "</table>";
				
				
				txt4 += "</div></div></div></div></div>";
				
				
				
				var txt3 = "<div class='container-fluid'><div class='panel-group2'>";
				txt3 += "<div class='panel panel-default'>";
				txt3 += "<div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#"+passosDados+"'>Dados Técnicos</a></h4></div>";
				txt3 += "<div id='"+passosDados+"' class='panel-collapse collapse'>";
				txt3 += "<div class='panel-body'>";
				//txt3 += allData[last-i].instalador;
				
				var j;
				txt3 += "<div><h3>Procedimentos realizados</h3><ul>";
				for(j = 0; j < allData[last-i].passos.length; j++){
					
					txt3 += "<li class='listaInfo'>"+allData[last-i].passos[j]+"</li>";
						
				}
				txt3 += "</ul></div>";
				
				txt3 += "<div><h3>Procedimentos não realizados</h3><ul>";
				for(j = 0; j < allData[last-i].passos_nao.length; j++){
					
					txt3 += "<li class='listaInfo'>"+allData[last-i].passos_nao[j]+"</li>";
						
				}
				txt3 += "</ul></div>";
				
				if(allData[last-i].motivo != ""){
					txt3 += "<div><h3>Comentário do responsável</h3><ul>";
					txt3 += "<li class='listaInfo'>"+allData[last-i].motivo+"</li></ul></div>";
				
					
				}
				
				
				txt3 += "</div></div></div></div></div>";
				

				
				txt += txt2+txt4+txt3;
				txt += "</div></div></div>";
			}
			txt += "</div></div>";
			$('#tabHistory').html(txt);
            
        }

        (function ($) {
            $(function () {
                function moveUpestado(thisObject) {
                    thisObject.appendTo(thisObject.parents('svg>g'));

                }
                $('.mapa-svg-estados').click(function () {
                    console.log($(this).attr('id'));
                    $(this).siblings().removeClass('mapa-svg-estados-active');
                    $(this).addClass('mapa-svg-estados-active');
                    $('.class-select').val($(this).attr('id')).trigger('change');
                    moveUpestado($(this));
                });

                $('.class-select > option').each(function () {
                    console.log("click options");
                    $(this).addClass($(this).attr('value'));
                });

                $('.class-select').change(function () {
                    
                    $('.' + $(this).val() + '-class').siblings().removeClass('mapa-svg-estados-active');
                    $('.' + $(this).val() + '-class').addClass('mapa-svg-estados-active');
                    moveUpestado($('.' + $(this).val() + '-class'));
                });
            });
        })(jQuery);

        //url: 'https://api.mlab.com/api/1/databases/tecsdb/collections/instalacaos?apiKey=FadNlSlxW08n39zzET_9idXHX-6AyL3w',
        //url: 'https://pacific-forest-15813.herokuapp.com/inst',
		
		var num;        
        var months = ["JAN", "FEV", "MAR", "ABR", "MAI", "JUN", "JUL", "AGO", "SET", "OUT", "NOV", "DEZ"];
        var ests = ["AC","AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"];
        var tHead = "<thead><tr><th></th><th>JAN</th><th>FEV</th><th>MAR</th><th>ABR</th><th>MAI</th><th>JUN</th><th>JUL</th><th>AGO</th><th>SET</th><th>OUT</th><th>NOV</th><th>DEZ</th><th>RATE</th></tr></thead>";
        var anoAt;
        $(document).ready(function () {

           
            anoAt = $("#anoAtual").val();
            $("#anoAtual").on("change", function () {
                anoAt = $("#anoAtual").val();
                reDraw();
            });

            

            $.ajax({
                //url: 'https://api.mlab.com/api/1/databases/tecsdb/collections/instalacaos?apiKey=FadNlSlxW08n39zzET_9idXHX-6AyL3w',
                url: 'https://pacific-forest-15813.herokuapp.com/inst3',
				//url: 'http://192.168.0.11:3000/inst3',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    allData = data;
                    var txt;
                    var arrayUnsort = [];
                    //var anoData = allData.filter(function (item) { var d = new Date(item.data["Sdate"]); return d.getFullYear() == anoAt; });
                    var anoData = allData.filter(function (item) { var d = new Date(item.data); return d.getFullYear() == anoAt; });

                    ests.forEach(function (item) {
                        arrayUnsort.push(makeLine(anoData, item));
                       
                    });
                   
                    var arraySort = arrayUnsort.sort(function (a, b) {
                        return parseFloat(b.len) - parseFloat(a.len);
                    });
                    var tBody = "<tbody>";
                    arraySort.forEach(function (item) {
                        tBody += item.txt;
                    });
                    tBody += "</tbody>";

                    //console.log(tBody);

                    var tabela = "<table id='t01'>" + tHead + tBody + "</table>";
                    $('#tabelaInfo').html(tabela);
					populateHist2();
					populateHistAll();




                    //var d = new Date(arrayItem.data["Sdate"]);
                    //$('#container').text(txt);
                    //alert(d.getWeek());
                    //console.log(d.getFullYear());
                },
                error: function (xhr, ajaxOptions, throwwnError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(throwwnError);
                    alert(throwwnError);
                }
            });
        });



        function reDraw() {
            var txt;
            var arrayUnsort = [];
            //var anoData = allData.filter(function (item) { var d = new Date(item.data["Sdate"]); return d.getFullYear() == anoAt; });
            var anoData = allData.filter(function (item) { var d = new Date(item.data); return d.getFullYear() == anoAt; });


            ests.forEach(function (item) {
                arrayUnsort.push(makeLine(anoData, item));

            });

            var arraySort = arrayUnsort.sort(function (a, b) {
                return parseFloat(b.len) - parseFloat(a.len);
            });
            var tBody = "<tbody>";
            arraySort.forEach(function (item) {
                tBody += item.txt;
            });
            tBody += "</tbody>";

            //console.log(tBody);

            var tabela = "<table id='t01'>" + tHead + tBody + "</table>";
            $('#tabelaInfo').html(tabela);

            //var d = new Date(arrayItem.data["Sdate"]);
            //$('#container').text(txt);
            //alert(d.getWeek());
            //console.log(d.getFullYear());
        }

        function makeLine(arr, estado) {

            var arrEst = arr.filter(function (item) {
                return item.estado == estado;
            });
            var stars = 0, i;
            for (i = 0; i < arrEst.length; i++) {
                stars += arrEst[i].estrela;
            }
          /*
            var Jan = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 0;});
            var Fev = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 1;});
            var Mar = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 2;});
            var Abr = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 3;});
            var Mai = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 4;});
            var Jun = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 5;});
            var Jul = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 6;});
            var Ago = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 7;});
            var Set = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 8;});
            var Out = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 9;});
            var Nov = arrEst.filter(function (item) {var d = new Date(item.data["Sdate"]);return d.getMonth() == 10;});
            var Dez = arrEst.filter(function (item) { var d = new Date(item.data["Sdate"]); return d.getMonth() == 11; });
			*/
			var Jan = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 0;});
            var Fev = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 1;});
            var Mar = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 2;});
            var Abr = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 3;});
            var Mai = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 4;});
            var Jun = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 5;});
            var Jul = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 6;});
            var Ago = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 7;});
            var Set = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 8;});
            var Out = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 9;});
            var Nov = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 10;});
            var Dez = arrEst.filter(function (item) {var d = new Date(item.data);return d.getMonth() == 11; });

            var nJan = (Jan.length == 0) ? "" : Jan.length;
            var nFev = (Fev.length == 0) ? "" : Fev.length;
            var nMar = (Mar.length == 0) ? "" : Mar.length;
            var nAbr = (Abr.length == 0) ? "" : Abr.length;
            var nMai = (Mai.length == 0) ? "" : Mai.length;
            var nJun = (Jun.length == 0) ? "" : Jun.length;
            var nJul = (Jul.length == 0) ? "" : Jul.length;
            var nAgo = (Ago.length == 0) ? "" : Ago.length;
            var nSet = (Set.length == 0) ? "" : Set.length;
            var nOut = (Out.length == 0) ? "" : Out.length;
            var nNov = (Nov.length == 0) ? "" : Nov.length;
            var nDez = (Dez.length == 0) ? "" : Dez.length;
            var txt = "<tr class='" + estado +"'>";
            txt += "<td>" + estado + "</td>";
            txt += "<td class='jan'>" + nJan + "</td>";
            txt += "<td class='fev'>" + nFev + "</td>";
            txt += "<td class='mar'>" + nMar + "</td>";
            txt += "<td class='abr'>" + nAbr + "</td>";
            txt += "<td class='mai'>" + nMai + "</td>";
            txt += "<td class='jun'>" + nJun + "</td>";
            txt += "<td class='jul'>" + nJul + "</td>";
            txt += "<td class='ago'>" + nAgo + "</td>";
            txt += "<td class='set'>" + nSet + "</td>";
            txt += "<td class='out'>" + nOut + "</td>";
            txt += "<td class='nov'>" + nNov + "</td>";
            txt += "<td class='dez'>" + nDez + "</td>";
            if (stars == 0) {
                txt += "<td></td>";
            } else {
                var rate = Math.round(10 * stars / arrEst.length) / 10;
                if (rate < 2) {
                    txt += "<td class='badRate'>" + rate + "</td>";
                } else {
                    txt += "<td class='goodRate'>" + rate + "</td>";
                }
            }

            txt += "</tr>"

            var obj = new Object();
            obj.txt = txt;
            obj.len = arrEst.length;
            return obj
        }
        
        
        /*var filtered = arr.filter(function (item) {
            return item.estado == "AR";
        });*/



    

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
$this->registerCss("
body {
            align-items: center;
            justify-content: center;
            --default-blue-stroke: #0098ff;
            --default-grey-black-fill: #525252;
            --default-strok: rgb(141, 141, 141);
        }
		
		.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

        table {
            border-collapse: collapse;
			
            width: 100%;
        }

        #t01 th, #t01 td {
            text-align: center;
            padding: 3px;
			   //4px na lg
//padding: 4px;
            border: 1px solid #dddddd;
			
        }
		
		.noback2{
		border: 1px solid black;
		}
		.noback2 th, .noback2 td{
		border: 1px solid black;
		text-align: center;
		}
		
		
		#tabelaMapa th, #tabelaMapa td {
            text-align: center;
            padding: 3px;
			   //4px na lg
//padding: 4px;
            border: 1px solid black;
			
        }

        #t01 tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        thead {
            background-color: #696969;
            color: #fff;
            text-align: center;
        }


        svg text {
            fill: var(--default-strok);
            font-family: monospace;
            font-weight: bolder;
        }

        .mapa-svg-estados {
            fill: #373737;
            -webkit-transition: .8s ease;
            -moz-transition: .8s ease;
            -o-transition: .8s ease;
            transition: .8s ease;
			
            stroke-dasharray: 0%;
            stroke-dashoffset: -120%;
            stroke-width: 1px;
            stroke: var(--default-strok);
        }
		
		.state-am-class, .state-pa-class, .state-rr-class, .state-ac-class, .state-ap-class, .state-ro-class, .state-to-class{
			fill:#c4ffc1;
		}
		
		.state-ma-class, .state-pi-class, .state-ce-class, .state-rn-class, .state-pb-class,
		.state-pe-class, .state-al-class, .state-se-class, .state-ba-class{
			fill:#a8feff;
		}
		
		.state-mt-class, .state-ms-class, .state-go-class, .state-df-class{
			fill:#feffa8;
		}
		.state-pr-class, .state-sc-class, .state-rs-class{
			fill:#ffa8fe;
		}
		.state-mg-class, .state-sp-class, .state-es-class, .state-rj-class{
			fill:#442d2d;
		}
		

        #headerC, #asc, #inst {
            text-align: center;
            line-height: 50%;
        }

        .map-area-transform {
            float: left;
			margin-left:10px;
        }

        .mapa-svg-estados text {
            stroke: none
        }
/*
        .mapa-svg-estados:hover {
            cursor: pointer;
            fill: var(--default-grey-black-fill);
        }
	*/	
		@keyframes blink {
	
            
		  0% {
			opacity: 1;
			fill: var(--default-grey-black-fill);
		  }
		  25% {
			opacity: 0.5;
			fill: var(--default-grey-black-fill);
		  }
		  50% {
			opacity: 1;
			fill: var(--default-grey-black-fill);
		  }
		  75% {
			opacity: 0.5;
			fill: var(--default-grey-black-fill);
		  }
		  100% {
			opacity:1;
			fill: var(--default-grey-black-fill);
		  }
		}

        .mapa-svg-estados-active {
            cursor: pointer;
			animation: blink 5000ms 1;
            //stroke: var(--default-blue-stroke);
            //fill: var(--default-grey-black-fill);
            stroke-dashoffset: 0%;
            -webkit-transition: .8s ease;
            -moz-transition: .8s ease;
            -o-transition: .8s ease;
        }

        .mapa-svg-estados-active text {
            stroke: none;
        }

        .pointer-svg-map {
            fill: var(--default-blue-stroke);
            animation-direction: normal;
            animation-delay: .3s;
        }

        .inactive-map-svg {
            opacity: .5;
            stroke: none !important;
        }

        .inactive-map-svg:hover {
            stroke-dashoffset: -120%;
            cursor: inherit;
            fill: var(--default-grey-black-fill);
        }

        @keyframes pointer {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
                transform: translateY(0px);
            }
        }

        #sotreq-select {
            display: flex;
            flex-direction: coluna;
        }

        .class-select {
            outline: none;
            height: 40px;
            width: 250px;
            padding: 10px 18px;
            border-radius: 32px;
            color: #3c3c3c;
        }
		
		#anoAtual{
		margin-top:10px;
		width: 80px;
		height: 30px;
		margin-bottom:10px;
		
          
		}
		
		#tabelaInfo{}

        .hist {
            width: 450px;
            height: 243px;
            overflow: auto;
        }

        .coluna {
            float: left;
			display: inline-block;
            border: 1px solid black;
            text-align: center;
            
            height: 81px; /* Should be removed. Only for demonstration */
            line-height: 81px;
        }

        .coluna2 {
            height: 81px;
            width:100%;
			border: 1px solid black;
          
        }

        .roww:after {
            content: '';
            display: table;
            clear: both;
        }

        .goodRate {
            background-color: #B0FC23;
            color: #000000;
        }

        .badRate {
            background-color: #dc143c;
            color: #fff;
        }
		
		.panel-group{
			float:left;
		width: 80%;
            height: 700px;
            overflow: auto;
		
		}
		
		.panel-group2{
			float:left;
			width: 100%;
		}
		
		h2,h3{
		
		text-align: center;
		
		}
		
		
		
		ul {
		  list-style-type: none;
		  margin: 0;
		  padding: 0;
		}
		 

		 
		.listaInfo:last-child {
		  border: none;
		}
		 
		.listaInfo {
		  text-decoration: none;
		  color: #000;
		  display: block;
		  width: 100%;
		  font-size: 20px;
		  
		 
		  -webkit-transition: font-size 0.3s ease, background-color 0.3s ease;
		  -moz-transition: font-size 0.3s ease, background-color 0.3s ease;
		  -o-transition: font-size 0.3s ease, background-color 0.3s ease;
		  -ms-transition: font-size 0.3s ease, background-color 0.3s ease;
		  transition: font-size 0.3s ease, background-color 0.3s ease;
		}
		 
		.listaInfo:hover {
		  font-size: 30px;
		}
		
		.alignleft {
			float: left;
			text-align:left;
			width:33.33333%;
			
		}
		.aligncenter {
			float: left;
			text-align:center;
			width:66.66666%;
		   
		}");
$this->registerJsFile('https://js.pusher.com/4.3/pusher.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<br>
<div class="statusrohs-index">
        <div class="box box-danger container">
           <ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#home">Overview</a></li>
		<li><a data-toggle="tab" href="#menu1">History</a></li>
	</ul>
	
	<div class="tab-content">
	
	

    <div class="map-area-transform">

        

        <svg xmlns="http://www.w3.org/2000/svg" class="mapa-svg-estados-svg" width="452" height="452"
             viewBox="150 60 452 452" class="a">
            <g id="mapa-svg-area">
                <g class="mapa-svg-estados state-go-class" id="state-go">
                    <path d="M461.9 266.5L463.7 268.4 462.7 269.3 462.5 271.1 463.5 272.6 462.4 273.2 461.5 275.9 462 279.8 463.1 281.9 465.3 283.9 464.8 285.8 465.4 287.5 464.2 289.4 463.4 290.2 461.2 289.9 459 287.7 458.2 288.8 458.5 291.3 456.2 291 454.9 291.4 454.4 295.6 455.1 297.5 455.4 300.6 450.5 302.5 449.9 301.9 450.4 297.5 449.2 296.5 441 296.3 440 300.2 441 302.5 450.5 302.5 450.2 304.7 448.8 307.6 450.9 309.5 452.1 312.7 450.1 315.1 448 318.3 450.6 319.4 450.9 320.7 449.9 322.8 450.7 325.2 447.7 326.9 446.7 328.2 444.1 329.6 440.2 328.5 434.2 328.5 432.7 328.2 430.8 329.1 428.3 331.6 426.9 330.1 423.7 331.6 421.6 331.4 418 332.6 416 335.2 415.8 337 414.5 337.1 412.4 339.2 411.1 341.2 409.5 339.1 407.6 338.8 406.3 337.7 403.8 337.3 399.4 335.2 398.1 334.1 396.3 333.7 394.8 332.5 390.7 332.2 391.6 329.6 388.6 327.8 388.7 324.7 386.6 319.9 387.1 316.4 388.8 313.7 389.7 311.2 391.3 310.4 393.1 308.1 392.9 305.3 394.4 303.6 396.4 302.5 397.8 300.8 401.1 299.9 403.1 296.2 403.7 293.3 405.2 291.6 407.3 290.4 408.9 290.7 409.6 289.7 411.1 285.4 410.8 284.2 411.6 281.1 412.3 281 412.3 276.6 415.3 271.5 415.4 269 416.3 267.1 416.7 265.4 418.5 263.1 419.3 265 418.5 266.4 418.9 268 424.9 270.7 427.7 271.5 430.7 265.8 431.6 265.2 434.1 267.4 434.7 269.8 435.9 270.8 441.1 270.7 446.7 272.6 445.9 270.7 449 271.5 452.7 269.8 456.1 269.4 457.5 267.9Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 412.5104 312.2663)" class="abreviation-state">GO</text>
                </g>
                <g class="mapa-svg-estados state-sp-class" id="state-sp">
                    <path d="M477 374.9L479 377.2 483.4 377.2 484.2 378.3 482.1 380.2 479.6 380.4 477.4 381.7 476.6 384.5 478.1 386 475.7 386.2 474.3 387.7 470.6 389.7 469.5 391.6 465.9 390.7 461.5 393.2 458.1 394.6 454 397.1 453.7 398.4 449 401.6 446.9 402.5 444.2 404.8 443.5 407.8 442.1 409 440.5 405.6 438.5 404.9 436.3 401.6 429 401.5 429.8 397.7 428.7 395.3 425.8 392.2 426.3 390.2 425.2 387.8 425.7 386.5 424.4 383.1 422.9 382.6 421.2 380.9 418.4 381.3 417.3 380.9 413.1 381.3 412 379.8 409.5 379.2 407 377.8 405.3 378.2 401.3 377.3 399.8 376.4 394.4 377.4 389.8 376.8 387.4 378.4 389.6 375.6 391 375.1 396 371.4 396.8 369.4 399.6 366.4 398.9 365.1 401.5 362.7 401.3 360.7 404 357.3 404.1 355.2 407.2 351.4 409.3 350.7 410.8 348.4 412.1 347.2 414.5 346.3 416.6 344.7 417.8 345.8 422.7 346.4 426.4 346.4 429 347.5 429.1 349.1 430.7 350.6 433.9 349.1 436.9 348.6 444.2 348.4 444.7 347 446.9 347.7 449 347.7 451.2 349.6 450.6 352.1 452.1 353.3 452.5 354.8 451.3 357.5 453.8 362.7 455.7 362.8 459 364 459.2 364.7 457.2 368.1 457.8 370.1 456.9 373.8 457.5 375.1 460.1 376.4 460.8 380.4 463.1 380.6 465.9 380.2 467.4 379.4 467.5 377.8 470.2 377.2 471 377.8 474.7 375.6Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 429.8438 374.2663)" class="abreviation-state">SP</text>
                </g>
                <g class="mapa-svg-estados state-pe-class" id="state-pe">
                    <path d="M583.7 209.2L584.7 210 583.7 212 584.6 213.1 583.2 218 581 224.1 577.5 223.2 574.9 224.1 574 223.6 571.7 223.8 568.2 227.2 565.5 228.2 562.4 227.9 561.7 228.8 559.2 227.6 556.9 225.4 555.1 224.4 552.3 224.9 547.8 228.6 547 226.3 544.9 224.4 541.1 222.5 537.3 221.5 535.3 219.9 532.3 221.2 532.2 222.6 530 223.2 530.1 224.6 527.6 226.1 526 226.1 525.4 228.8 522.2 230.3 521.3 227.4 519.6 226.4 519.4 223.5 516.4 221.8 514.2 221.9 519 218.9 522.6 215.4 523.1 212.5 521.8 211.5 522.2 210.2 521.5 207.9 523.1 207.5 528.2 207.7 530.5 207.1 532.6 207.3 536 209.3 537 210.7 540 212.5 541 211 542.9 210 544.9 211.6 546.6 210.9 547.7 212.5 548.7 211.7 551.1 211.3 553.5 209.2 555.2 208.5 556.4 207 558.3 206.3 560.4 207.5 561 208.8 558.9 209.6 559.3 211.5 558.1 213.3 559.6 213.9 559.7 215.9 561.8 217.2 563.4 216.5 565.1 215 565.7 213.3 567.3 212.2 572.4 212.2 573 211.6 576.6 210.4 577.2 208.2 579.5 207.5 581.9 207.7Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 545.8438 221.5996)" class="abreviation-state">PE</text>
                </g>
                <g class="mapa-svg-estados state-ac-class" id="state-ac">
                    <path d="M240.7 234.1L242.6 235 236.9 239.4 235.4 239.4 232.6 241.4 231.2 243.6 229.7 243.1 227.1 243.5 225.4 246.1 223.5 247.3 220 248.4 219.5 246.7 213.2 246.1 209.7 246.4 207.2 245.9 203 247.6 201 246.1 199.8 246.9 199.8 234.3 200.3 229.8 197.3 232.2 195.8 233.9 193.8 235.2 191.7 236 183.1 236 183.5 234.7 181 230.4 176.5 229.5 172.1 229.5 174.9 225.9 174.7 224.8 172.6 221.9 170.7 220.6 170.5 219.2 168.8 218.2 167.3 214.3 166.1 213.7 166.8 211.8 164.1 209.6 163.9 207.3 166.8 206.6 165.8 204.6 178.1 209.7 202.7 215.9 208.8 219.1Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 205.8438 237.5996)" class="abreviation-state">AC</text>
                </g>
                <g class="mapa-svg-estados state-am-class" id="state-am">
                    <path d="M326.2 125.5L326.3 131.4 327.6 132.5 327.5 134.8 329 136.2 330.7 137 331.1 138.8 334.7 141.9 337.4 143.4 339.2 145 345.4 147.5 346.4 148.8 348.9 149.8 349 151.3 350.2 151.8 351.5 151.2 352.7 152.3 352.9 153.6 348.9 162.2 332.4 197.8 330.5 200.7 331.5 203 333.5 205 334.1 206.9 333.2 208 333 210.3 331.5 212.2 332.2 215.4 330.5 221.6 329.7 222.2 296.8 222.5 295.5 221.6 293.7 223.6 291.1 222.4 290.8 220.7 289.4 220.4 288.5 218.2 286.8 218.1 284.8 214.8 282.9 214.2 276.1 214.2 275.5 215.9 273.9 217.2 272 217.7 272 219.9 271.2 221.4 269.6 221.7 269.8 224.3 267 224.3 265.1 225.2 262.7 224.9 261.6 225.6 261.2 227.7 259.9 229.5 258.8 229.5 258.1 227.8 255.2 229.9 253.4 230 252.3 231.2 250.2 229.4 245.4 229.4 245.4 230.6 244.2 231.9 241.7 233.1 240.7 234.1 208.8 219.1 202.7 215.9 178.1 209.7 165.8 204.6 166.2 202.3 167.1 201.2 170.7 198.7 171.9 198.6 173 197.2 171.9 193.3 173 191.2 174.4 189.3 174.7 186.7 175.6 184.5 175.3 183.2 178.1 182.4 184.4 177.5 186.3 176.4 190.5 175.7 192.1 175.8 195.1 174.9 196.3 175.1 198.2 172.6 200.3 173 202.1 172.4 204.5 174.6 206.3 174.6 207.2 173.1 210.4 155.8 213.1 140.6 212.6 138.7 210.7 135.8 210.5 133.2 207.2 131.2 205.9 129.7 206.2 121.7 208.3 121.5 212.5 120.1 213.5 121.1 215.4 120.4 215.8 118.6 214.3 116.8 211 116.4 208.3 116.6 208.2 109.6 211.2 108.9 213.7 109.4 226.4 109.4 225.4 108 227 107 228.2 109.2 230.4 108.4 232.5 105.8 235 105.2 237.7 109.6 238.1 111.4 238 115.3 240.2 114.8 245.3 119.4 248.5 120 252.6 117.3 254.8 118.4 254.1 120 255.6 120.5 256.9 118.2 258.4 117.7 258.9 115.8 260.1 115.7 262.1 114.3 263.3 114.5 266.4 111.9 267.9 112.4 270.1 110.5 270.5 107.6 271.1 106.9 273.7 106.6 275.2 105.4 277.4 104.8 277.7 103.9 280 104.5 281.3 106 285 107 284.9 109.5 284.1 110.7 286 112.9 287.8 119.3 286.8 120 287.3 122.1 286.5 125.3 287 126.9 286.3 127.8 287.3 130.2 288.6 131.4 289.3 134.4 287.1 136.2 289.2 138.1 292.3 140.2 293.9 142.6 296.8 143 296.6 141.6 297.3 139 297.5 136.2 298.3 134.8 302.2 133.2 304.1 133.9 306.1 137.1 308.5 136.8 310.7 135.3 309.8 133.5 310.7 130.4 312.7 126.5 313.8 125.5Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 264.8438 177.5996)" class="abreviation-state">AM</text>
                </g>
                <g class="mapa-svg-estados state-pa-class" id="state-pa">
                    <path d="M412.6 134.2L412.4 135.6 409.6 136.8 409.6 135.8 411.2 134.4ZM408.3 133.9L409.1 134.8 407.8 138.8 402.3 143.5 400.5 143.2 401.3 141.3 403 140.1 403.5 137 405 134.8 407.4 133.5ZM420.5 129.4L425.2 130.5 427.7 130.4 428.7 129.6 433 129.7 433.4 130.2 438.4 130.7 439 131.9 438 133.2 437.3 137.3 436.2 139.4 434.4 140.7 433.9 143.4 429.8 145.4 428.2 145.6 426.8 145 425.2 146.8 423.4 147.5 421 146.3 419.8 147 417.1 147.6 415.3 147.2 415.2 146 413.5 144.4 412.8 142.4 413.1 140.7 412.9 137.7 413.1 135 414.5 130.8 417.5 129ZM411.9 131.2L410.4 129.7 411.3 128 413.3 127.4 414.6 129.2ZM427 127.2L428.3 127.6 427.5 129.2 424.5 129.5 425.5 127.3ZM426.6 124.7L424.8 125.8 423.3 127.8 421.4 128.5 420.5 127.6 418.3 127.8 417.5 125.6 420.3 125.5 421.1 124.7 423 124.7 425.3 123.8ZM417.8 122.3L418 124.9 416.4 125 416.8 122.2ZM421.1 121.6L421 122.4 418.5 124.1 418.9 121.6ZM370.2 101.5L370.9 103.6 370.1 105.1 370.7 108.9 374.6 109 376.9 110.2 377.8 111.8 379.8 112.9 382.1 112.6 384.2 115.8 384.8 117.8 388.1 120.6 387.9 123.8 388.8 125.2 390.1 130 391.1 129.9 393.3 132.2 393.2 133.9 394.4 134.9 394.4 137.1 395.6 137.2 396.1 139.4 399.4 140.6 401 140.4 400.9 142.2 399.3 143 397.4 142.4 393.8 144.3 395.4 144.8 397 144.2 398.3 145.5 400.4 145.1 403.5 143 407.7 141.2 410.4 139.1 410.8 137.8 412.6 137.8 411.7 140 412.7 141.2 412.7 143.4 414.1 145.2 415.4 148.3 416.5 148.6 421.2 147.5 424.4 148.5 427.2 146.9 428.2 148.3 427.4 151.4 428.7 151.6 430.9 146.9 432.6 145.1 434.2 145.4 436.1 142.8 437.2 144.9 437.8 141.7 439.3 142.1 440 140 441.5 137.6 441.3 136.3 443.5 135.9 445.9 134.8 448.7 135.8 450.7 134.4 454.9 136.9 459.2 137.3 459.4 138.9 461.2 139 462 140.2 463.5 140.9 462.9 141.2 462 146.4 462 149.1 461.4 150.9 459.6 153.3 459.9 154.9 457.3 157.3 457.3 161.2 455.7 163.6 454.3 164.4 453.4 166.3 453 169.2 450.6 171.8 449.6 173.9 446.7 177.5 445.1 177.3 435.1 185.4 435.2 185.5 437 186.2 438.7 185.9 441.5 188.7 439.8 189.6 440.5 191.3 439.3 192.3 439.9 193.5 438.3 194.3 437.6 196.3 435.8 198.3 435.6 199.7 432.1 200.9 430.1 202.2 430.2 205.8 428.2 208.7 428.2 210.3 430.3 211.8 430.1 214.8 428.9 218.3 428.1 218.9 426 223.2 424.1 224.1 420.9 228.5 420.3 231.1 419 234.2 407.6 233.6 366.8 231.1 352.1 230.1 348 228 345.5 227.3 345.2 225.6 343.1 224.5 340 222.4 339 219 339.4 216.6 337.9 214.7 335.8 209 334.1 206.9 333.5 205 331.5 203 330.5 200.7 332.4 197.8 348.9 162.2 352.9 153.6 352.7 152.3 351.5 151.2 350.2 151.8 349 151.3 348.9 149.8 346.4 148.8 345.4 147.5 339.2 145 337.4 143.4 334.7 141.9 331.1 138.8 330.7 137 329 136.2 327.5 134.8 327.6 132.5 326.3 131.4 326.2 125.5 325.1 113.8 326.4 115.1 328.2 114.1 330 114.3 330 112.4 332.2 110.7 335.3 111.6 336.2 110.3 337.8 109.6 340.2 109.6 342.6 106.8 345.2 106.2 346.2 107.3 348.5 107.8 350.4 107.2 353.5 107.3 356.8 108.2 357.9 107.7 357.9 106 356.4 104 357.1 101 360 102.2 363.5 101.8 364.6 100.9 367.4 100.2 369.1 101.6Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 382.8438 187.5996)" class="abreviation-state">PA</text>
                </g>
                <g class="mapa-svg-estados state-ro-class" id="state-ro">
                    <path d="M296.8 222.5L298.1 224.1 296.8 228.6 298.1 232 297.1 237.3 298.3 240.9 297.7 244.5 298.3 246.8 309.3 246.9 314.2 248.5 315 250.7 312.9 254 313.4 256.7 314.3 256.9 315.3 259.1 316 262.1 313.2 268 312 268.4 310.3 271.8 309.7 273.7 306.3 276.1 304.5 274.9 299.6 274.2 294.6 274.8 291.5 271.7 291.4 270.4 288 270.2 287.7 269.6 284.3 268.9 282 267 281.1 264.9 278.4 265.5 276.6 263.9 274.8 263 272.6 262.9 272 263.7 266.8 262.8 266.1 260.6 263.4 259.4 262.6 258.1 260.7 257.9 259.7 255.1 258.2 254.8 258 252.5 256.6 251.1 256.1 248.5 257.1 246.7 256 244.6 255.6 241 257.3 238.1 256.7 235.5 257.1 234.2 255.6 232.4 254.1 234.1 251.7 233.2 248.7 233.5 244.8 234.7 242.6 235 240.7 234.1 241.7 233.1 244.2 231.9 245.4 230.6 245.4 229.4 250.2 229.4 252.3 231.2 253.4 230 255.2 229.9 258.1 227.8 258.8 229.5 259.9 229.5 261.2 227.7 261.6 225.6 262.7 224.9 265.1 225.2 267 224.3 269.8 224.3 269.6 221.7 271.2 221.4 272 219.9 272 217.7 273.9 217.2 275.5 215.9 276.1 214.2 282.9 214.2 284.8 214.8 286.8 218.1 288.5 218.2 289.4 220.4 290.8 220.7 291.1 222.4 293.7 223.6 295.5 221.6Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 274.5104 251.5996)" class="abreviation-state">RO</text>
                </g>
                <g class="mapa-svg-estados state-to-class" id="state-to">
                    <path d="M465 239.4L467 239.5 466.5 240.5 463.5 242.2 461.1 244.2 461.9 245.5 460.3 246.7 458.3 250.6 459.9 252.3 462.4 252.7 463.1 254.3 461.7 254.8 463.6 257 460.8 259.2 461 262.4 462.7 263.3 461.9 266.5 457.5 267.9 456.1 269.4 452.7 269.8 449 271.5 445.9 270.7 446.7 272.6 441.1 270.7 435.9 270.8 434.7 269.8 434.1 267.4 431.6 265.2 430.7 265.8 427.7 271.5 424.9 270.7 418.9 268 418.5 266.4 419.3 265 418.5 263.1 416.7 265.4 416.3 267.1 415.1 266.6 414.5 263.8 414.9 262.5 414.3 259.9 414.5 257.5 413.9 254.6 414.5 253.3 413.5 252.4 414.9 247.5 415 243.3 416.9 239.6 417.2 237.6 419 234.2 420.3 231.1 420.9 228.5 424.1 224.1 426 223.2 428.1 218.9 428.9 218.3 430.1 214.8 430.3 211.8 428.2 210.3 428.2 208.7 430.2 205.8 430.1 202.2 432.1 200.9 435.6 199.7 435.8 198.3 437.6 196.3 438.3 194.3 439.9 193.5 439.3 192.3 440.5 191.3 439.8 189.6 441.5 188.7 438.7 185.9 437 186.2 435.2 185.5 437.3 183.9 439.3 183.5 441.3 184.5 443 184.2 448.2 187 448.5 189.7 449.3 191.1 449.1 193.6 449.7 195 448.9 198.3 448.2 203.4 446.9 205 448.2 206.3 448.4 208.1 450.6 210.5 453.5 214.6 455.1 213.7 458.2 213 459.2 213.7 459 218.5 456.7 218.6 455.5 219.2 454.5 222.2 454.7 223.2 452.9 224.9 455.4 226.9 456.4 229.5 458.7 231 457.2 233.1 459.2 234.5 459.4 236 460.7 237.7 463.5 238.2Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 433.8438 244.2663)" class="abreviation-state">TO</text>
                </g>
                <g class="mapa-svg-estados state-df-class" id="state-df">
                    <path d="M450.5 302.5L441 302.5 440 300.2 441 296.3 449.2 296.5 450.4 297.5 449.9 301.9Z" class="b" />
                    <text transform="matrix(1 0 0 1 441.1771 294.9329)" class="abreviation-state">DF</text>
                </g>
                <g class="mapa-svg-estados state-ms-class" id="state-ms">
                    <path d="M388.7 324.7L388.6 327.8 391.6 329.6 390.7 332.2 394.8 332.5 396.3 333.7 398.1 334.1 399.4 335.2 403.8 337.3 406.3 337.7 407.6 338.8 409.5 339.1 411.1 341.2 410.5 344.5 410.8 348.4 409.3 350.7 407.2 351.4 404.1 355.2 404 357.3 401.3 360.7 401.5 362.7 398.9 365.1 399.6 366.4 396.8 369.4 396 371.4 391 375.1 389.6 375.6 387.4 378.4 384.1 379.9 382.8 380.9 382.4 383.1 381.2 385.7 379.1 386.8 377.8 391.4 377.7 393 375.9 394.2 371.9 391.3 368.6 393.1 365.6 393.8 363.1 392.8 363 390.5 362.1 388.9 362.3 386.3 360.7 379.7 361.1 377.7 359.8 376.5 359.7 375.1 358.2 373.8 354.9 373.5 352.5 371.1 350.8 372.5 347.6 373.6 343.9 372.5 342.2 372.7 337.2 371.9 335.7 370.6 336.7 366.6 336.1 364.6 337 362.8 337.2 359.2 336.5 357.4 337 355.6 335.9 354.7 335.5 352.8 333.9 349.1 337 347 334.2 344.2 338.5 335.2 337.9 334.8 340.4 326.6 338.5 322.8 338.5 321.5 341.3 323.4 345 322.1 346.5 320.6 348.9 316.8 353.5 316.5 356.4 315.4 359.3 317.2 361 317.5 362 318.9 365.9 321 368.9 320.6 371.1 319.1 372.7 319 374.7 320.9 376.9 320.3 380.9 316.2 381.9 316.1 381.2 320.5 380 321 378.7 323.3 381.4 324.6 386 324.5Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 361.8438 352.2663)" class="abreviation-state">MS</text>
                </g>
                <g class="mapa-svg-estados state-mg-class" id="state-mg">
                    <path d="M526.6 324.2L524.4 323.4 519.1 324.2 518.8 325.7 516.6 327.8 518.1 329.4 517.8 331.7 519 332.3 517.6 336.2 518.8 337.8 518.6 341.2 516.4 343.7 516.2 345.7 514.9 346.6 514.2 349.4 510.3 349.6 508.8 356.2 506.4 358.8 503.4 366 504.4 366.9 496.3 370.6 493 370.3 491.7 370.9 488.4 370.9 484.9 372.2 483.6 373.1 481.2 373.2 477 374.9 474.7 375.6 471 377.8 470.2 377.2 467.5 377.8 467.4 379.4 465.9 380.2 463.1 380.6 460.8 380.4 460.1 376.4 457.5 375.1 456.9 373.8 457.8 370.1 457.2 368.1 459.2 364.7 459 364 455.7 362.8 453.8 362.7 451.3 357.5 452.5 354.8 452.1 353.3 450.6 352.1 451.2 349.6 449 347.7 446.9 347.7 444.7 347 444.2 348.4 436.9 348.6 433.9 349.1 430.7 350.6 429.1 349.1 429 347.5 426.4 346.4 422.7 346.4 417.8 345.8 416.6 344.7 414.5 346.3 412.1 347.2 410.8 348.4 410.5 344.5 411.1 341.2 412.4 339.2 414.5 337.1 415.8 337 416 335.2 418 332.6 421.6 331.4 423.7 331.6 426.9 330.1 428.3 331.6 430.8 329.1 432.7 328.2 434.2 328.5 440.2 328.5 444.1 329.6 446.7 328.2 447.7 326.9 450.7 325.2 449.9 322.8 450.9 320.7 450.6 319.4 448 318.3 450.1 315.1 452.1 312.7 450.9 309.5 448.8 307.6 450.2 304.7 450.5 302.5 455.4 300.6 455.1 297.5 454.4 295.6 454.9 291.4 456.2 291 458.5 291.3 458.2 288.8 459 287.7 461.2 289.9 463.4 290.2 464.2 289.4 465.2 292.3 467.2 292.5 469.2 290.2 470.4 290.2 472.9 287.9 476.5 286.5 477 285.5 479.9 283.6 482.3 282.6 486 282.9 488.1 283.6 487.2 286 487.4 287.2 491.4 288.6 494.4 286.8 497 287.3 500.6 290.2 506.4 292.9 509.5 292.1 514.3 296.4 514.6 298.9 516.5 299.6 518.3 298.6 521.8 298.9 526.5 300.1 530.4 303.4 529.6 305.4 528.3 306.5 527.4 308.2 526.1 308.4 525.7 311.9 523.8 311.8 522.7 314.7 523.7 319.5 526.9 322.4Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 477.8438 333.5996)" class="abreviation-state">MG</text>
                </g>
                <g class="mapa-svg-estados state-mt-class" id="state-mt">
                    <path d="M419 234.2L417.2 237.6 416.9 239.6 415 243.3 414.9 247.5 413.5 252.4 414.5 253.3 413.9 254.6 414.5 257.5 414.3 259.9 414.9 262.5 414.5 263.8 415.1 266.6 416.3 267.1 415.4 269 415.3 271.5 412.3 276.6 412.3 281 411.6 281.1 410.8 284.2 411.1 285.4 409.6 289.7 408.9 290.7 407.3 290.4 405.2 291.6 403.7 293.3 403.1 296.2 401.1 299.9 397.8 300.8 396.4 302.5 394.4 303.6 392.9 305.3 393.1 308.1 391.3 310.4 389.7 311.2 388.8 313.7 387.1 316.4 386.6 319.9 388.7 324.7 386 324.5 381.4 324.6 378.7 323.3 380 321 381.2 320.5 381.9 316.1 380.9 316.2 376.9 320.3 374.7 320.9 372.7 319 371.1 319.1 368.9 320.6 365.9 321 362 318.9 361 317.5 359.3 317.2 356.4 315.4 353.5 316.5 348.9 316.8 346.5 320.6 345 322.1 341.3 323.4 338.5 321.5 337.5 319.1 335.7 319 333.1 317 331.5 316.2 330.5 311.8 330.5 309.3 331.7 307.8 331.9 305.3 329.8 305.7 312.7 305.1 312.1 304.5 311.5 296.5 308.4 292.5 311.1 292 311 286.8 309 281 309.9 279.5 309.1 277.8 306.3 276.1 309.7 273.7 310.3 271.8 312 268.4 313.2 268 316 262.1 315.3 259.1 314.3 256.9 313.4 256.7 312.9 254 315 250.7 314.2 248.5 309.3 246.9 298.3 246.8 297.7 244.5 298.3 240.9 297.1 237.3 298.1 232 296.8 228.6 298.1 224.1 296.8 222.5 329.7 222.2 330.5 221.6 332.2 215.4 331.5 212.2 333 210.3 333.2 208 334.1 206.9 335.8 209 337.9 214.7 339.4 216.6 339 219 340 222.4 343.1 224.5 345.2 225.6 345.5 227.3 348 228 352.1 230.1 366.8 231.1 407.6 233.6Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 350.5104 270.9329)" class="abreviation-state">MT</text>
                </g>
                <g class="mapa-svg-estados state-rs-class" id="state-rs">
                    <path d="M424.6 457.6L421 463.6 418.1 471.7 413.7 479 409.1 484.5 404.7 488.2 401.5 490.2 399.6 492.4 399.1 489.2 400.8 489.4 403.2 488.4 406.3 484.9 408.1 484.3 409.1 482 408.9 480.3 410.8 479 411 477.2 413.3 476.1 414.1 475 415.7 469.3 411.8 469.8 409.3 469 407.6 473.7 406.7 474 406.8 477 406 479.5 404.1 480.1 403.7 481.7 400.8 482.3 400.2 485.7 397.8 487.6 398.1 489.8 397.2 491.7 398.9 492 395.9 497.3 394.9 501.2 393.3 505.1 391.2 507.9 385.2 513.3 383.4 512.1 383.8 505 385.9 503.3 387.9 500.6 386.4 498.7 383.2 496.7 381 491.6 377.6 489.5 376.9 489.9 373.5 486.9 372.2 484.3 369.7 483.9 365 481.3 364 479.2 361.4 476.5 358.5 479.4 356.8 479.2 357.2 476.6 354.7 473.2 352.9 471.9 350 468.7 348.1 467.2 345.5 467.3 344 469.5 340.8 469.4 340 468.5 342.8 465.8 343 464.1 345.1 463.1 349.7 457.7 350.8 455.2 352.6 454.3 353.9 451.1 355.1 450.5 358.1 447 359.6 444.5 361.3 442.8 363.1 442.4 365.7 439.7 367.5 439.4 368.7 438.2 369.6 435.9 371 436 375.4 434.5 376.5 432.5 380.2 431.3 384.9 430.8 387.5 431.4 389 430.8 392.1 432.3 394.2 432.1 398.1 432.5 401 434.9 404.3 435.3 405.9 436.2 408.3 438.6 409.9 439.2 412 441.7 414.8 446 415.7 446.5 422.1 447.1 424.6 447.9 422.3 450.2 422.1 453 420.6 456.6 422.9 456.3Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 379.1771 458.933)" class="abreviation-state">RS</text>
                </g>
                <g class="mapa-svg-estados state-pr-class" id="state-pr">
                    <path d="M442.1 409L439.3 409.2 437.3 411.5 438.3 412.8 436.7 417.1 430.9 417.2 426 420 422.1 417.5 414.5 418.1 412.5 420.4 409.9 420.1 407.6 422.4 408.2 424.6 406.5 425.4 405.3 424.5 399.8 424.2 398.1 422.8 395 422.4 391.2 421.3 388 421.7 385.4 420.2 383.9 420.8 382.1 420.4 380.3 416.7 379.5 412.8 376.2 411.7 373.6 413 372.2 411.9 372 410.5 373.9 406.9 373.5 406 375.1 401 375.7 397.5 374.9 395.3 375.9 394.2 377.7 393 377.8 391.4 379.1 386.8 381.2 385.7 382.4 383.1 382.8 380.9 384.1 379.9 387.4 378.4 389.8 376.8 394.4 377.4 399.8 376.4 401.3 377.3 405.3 378.2 407 377.8 409.5 379.2 412 379.8 413.1 381.3 417.3 380.9 418.4 381.3 421.2 380.9 422.9 382.6 424.4 383.1 425.7 386.5 425.2 387.8 426.3 390.2 425.8 392.2 428.7 395.3 429.8 397.7 429 401.5 436.3 401.6 438.5 404.9 440.5 405.6Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 395.1771 402.2663)" class="abreviation-state">PR</text>
                </g>
                <g class="mapa-svg-estados state-sc-class" id="state-sc">
                    <path d="M437.1 439.2L437.6 435.8 438.6 436.3ZM436.7 417.1L436.7 419.2 435 421.1 436.5 422.5 435.7 426.1 436.2 427.5 436.3 432.2 436.9 433.2 436 435.1 436.8 439.4 435.5 445.6 432.9 449.3 428.5 452.7 424.6 457.6 422.9 456.3 420.6 456.6 422.1 453 422.3 450.2 424.6 447.9 422.1 447.1 415.7 446.5 414.8 446 412 441.7 409.9 439.2 408.3 438.6 405.9 436.2 404.3 435.3 401 434.9 398.1 432.5 394.2 432.1 392.1 432.3 389 430.8 387.5 431.4 384.9 430.8 380.2 431.3 381.6 428.1 381 426 382.1 420.4 383.9 420.8 385.4 420.2 388 421.7 391.2 421.3 395 422.4 398.1 422.8 399.8 424.2 405.3 424.5 406.5 425.4 408.2 424.6 407.6 422.4 409.9 420.1 412.5 420.4 414.5 418.1 422.1 417.5 426 420 430.9 417.2Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 415.1771 435.5996)" class="abreviation-state">SC</text>
                </g>
                <g class="mapa-svg-estados state-al-class" id="state-al">
                    <path d="M581 224.1L579.3 227.1 577.4 229 575.1 232.3 573.4 233 573.1 234.3 571.4 236.6 568.7 239.1 567.5 241.3 566.9 240.4 563 238.2 561.7 236 558.7 234.7 557.9 233.7 555.5 233.1 550.4 230.7 548.3 229.6 547.8 228.6 552.3 224.9 555.1 224.4 556.9 225.4 559.2 227.6 561.7 228.8 562.4 227.9 565.5 228.2 568.2 227.2 571.7 223.8 574 223.6 574.9 224.1 577.5 223.2Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 565.8438 233.5996)" class="abreviation-state">AL</text>
                </g>
                <g class="mapa-svg-estados state-ba-class" id="state-ba">
                    <path d="M547.8 228.6L548.3 229.6 550.4 230.7 550.1 232.9 550.7 234.5 552.8 237.1 552.2 240.5 552.3 243.3 550.7 244.1 548.2 243.8 547.7 245.4 550.6 249.6 550.3 250.8 554 252.9 555.9 252.5 556.7 252.3 554.1 258.3 549.8 264.8 546.5 268.4 544.9 265.7 542.6 264.6 542.3 268.3 538.9 273.6 540 276.2 539.4 279.3 540.5 279.9 539.7 282.2 538.9 287.3 539.4 288.9 539.6 293.5 540.5 298.9 541.1 300.3 539.1 306.9 537.4 315.1 537.3 317.6 538 321.3 536.7 323 534.3 324.6 532.4 328.2 526.6 324.2 526.9 322.4 523.7 319.5 522.7 314.7 523.8 311.8 525.7 311.9 526.1 308.4 527.4 308.2 528.3 306.5 529.6 305.4 530.4 303.4 526.5 300.1 521.8 298.9 518.3 298.6 516.5 299.6 514.6 298.9 514.3 296.4 509.5 292.1 506.4 292.9 500.6 290.2 497 287.3 494.4 286.8 491.4 288.6 487.4 287.2 487.2 286 488.1 283.6 486 282.9 482.3 282.6 479.9 283.6 477 285.5 476.5 286.5 472.9 287.9 470.4 290.2 469.2 290.2 467.2 292.5 465.2 292.3 464.2 289.4 465.4 287.5 464.8 285.8 465.3 283.9 463.1 281.9 462 279.8 461.5 275.9 462.4 273.2 463.5 272.6 462.5 271.1 462.7 269.3 463.7 268.4 461.9 266.5 462.7 263.3 461 262.4 460.8 259.2 463.6 257 461.7 254.8 463.1 254.3 462.4 252.7 459.9 252.3 458.3 250.6 460.3 246.7 461.9 245.5 461.1 244.2 463.5 242.2 466.5 240.5 467 239.5 468.7 239.5 470.1 241.2 471.7 244.4 474.6 245.7 476.9 245.5 480 242.8 481.6 242.3 483.4 242.8 484.7 242.3 486.9 240 488.5 237.8 489.2 236 488.9 233.2 487.8 229.7 489.1 229.9 490.1 228.6 491.8 228.3 492.6 229.5 496.2 229.3 498.3 231 502.2 230.4 503.8 228.5 505.8 228.2 506.8 227.3 509.3 227.5 510.3 226.6 510.3 224.8 512.3 224.6 514.2 221.9 516.4 221.8 519.4 223.5 519.6 226.4 521.3 227.4 522.2 230.3 525.4 228.8 526 226.1 527.6 226.1 530.1 224.6 530 223.2 532.2 222.6 532.3 221.2 535.3 219.9 537.3 221.5 541.1 222.5 544.9 224.4 547 226.3Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 503.8438 264.9329)" class="abreviation-state">BA</text>
                </g>
                <g class="mapa-svg-estados state-es-class" id="state-es">
                    <path d="M526.6 324.2L532.4 328.2 531.8 330.4 531.7 334.7 532 340.6 530.7 343.3 528.6 344.5 527 347.7 526.8 349.4 525.7 349.9 525.1 353 522.8 355.9 520.7 357.1 519.8 359.8 518.5 361.9 517.5 361.2 515.4 361.4 511.9 360.6 510.3 359.7 510.4 357.2 508.8 356.2 510.3 349.6 514.2 349.4 514.9 346.6 516.2 345.7 516.4 343.7 518.6 341.2 518.8 337.8 517.6 336.2 519 332.3 517.8 331.7 518.1 329.4 516.6 327.8 518.8 325.7 519.1 324.2 524.4 323.4Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 521.8438 350.9329)" class="abreviation-state">ES</text>
                </g>
                <g class="mapa-svg-estados state-pb-class" id="state-pb">
                    <path d="M583 197.9L582.9 199.2 583.9 203.2 584.8 205 584.6 209.1 583.7 209.2 581.9 207.7 579.5 207.5 577.2 208.2 576.6 210.4 573 211.6 572.4 212.2 567.3 212.2 565.7 213.3 565.1 215 563.4 216.5 561.8 217.2 559.7 215.9 559.6 213.9 558.1 213.3 559.3 211.5 558.9 209.6 561 208.8 560.4 207.5 558.3 206.3 556.4 207 555.2 208.5 553.5 209.2 551.1 211.3 548.7 211.7 547.7 212.5 546.6 210.9 544.9 211.6 542.9 210 544.7 206.6 543.2 205.1 542.3 202.8 544.7 196.6 547.3 198 549 198.1 552.6 195.7 553 194.4 558.3 192.8 559.2 193.8 557 196.4 555.7 199.9 557.5 200 558.7 201.4 560.5 200.7 563.4 200.8 564.2 203 565.8 202.4 566.5 196.7 568.7 195.8 569.1 197 572.7 197.5 575.5 197.1 578.7 198 582.2 198.3Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 565.8438 208.9329)" class="abreviation-state">PB</text>
                </g>
                <g class="mapa-svg-estados state-rj-class" id="state-rj">
                    <path d="M518.5 361.9L517.4 364.7 518.5 369.6 518.2 370.4 515.5 371.9 511 373.5 507.4 377.3 508.1 379.2 506.8 381.3 503.4 381.1 496.3 381.6 495.8 378 493.8 378.9 494.9 380.7 494.3 381.8 489.9 382.2 487.4 380.8 485.2 381.3 483.9 382.5 482.1 381.1 478.9 382.4 478.1 386 476.6 384.5 477.4 381.7 479.6 380.4 482.1 380.2 484.2 378.3 483.4 377.2 479 377.2 477 374.9 481.2 373.2 483.6 373.1 484.9 372.2 488.4 370.9 491.7 370.9 493 370.3 496.3 370.6 504.4 366.9 503.4 366 506.4 358.8 508.8 356.2 510.4 357.2 510.3 359.7 511.9 360.6 515.4 361.4 517.5 361.2Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 498.5104 377.5996)" class="abreviation-state">RJ</text>
                </g>
                <g class="mapa-svg-estados state-rn-class" id="state-rn">
                    <path d="M583 197.9L582.2 198.3 578.7 198 575.5 197.1 572.7 197.5 569.1 197 568.7 195.8 566.5 196.7 565.8 202.4 564.2 203 563.4 200.8 560.5 200.7 558.7 201.4 557.5 200 555.7 199.9 557 196.4 559.2 193.8 558.3 192.8 553 194.4 552.6 195.7 549 198.1 547.3 198 544.7 196.6 544 195.6 545.8 193.1 547.2 193.3 549 191.2 549.9 188.3 551.3 186.7 553.3 182.5 555.3 181 558.5 179.9 559.1 180.8 562.2 181 564.4 182.7 568.8 182.8 571.9 182.2 576.4 183 578.1 184 579.8 186.9 581.6 194.6Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 563.8438 190.9329)" class="abreviation-state">RN</text>
                </g>
                <g class="mapa-svg-estados state-se-class" id="state-se">
                    <path d="M567.5 241.3L565.7 241.9 562.1 244.3 560.8 246.1 559.5 248.9 557.7 251.2 555.9 252.5 554 252.9 550.3 250.8 550.6 249.6 547.7 245.4 548.2 243.8 550.7 244.1 552.3 243.3 552.2 240.5 552.8 237.1 550.7 234.5 550.1 232.9 550.4 230.7 555.5 233.1 557.9 233.7 558.7 234.7 561.7 236 563 238.2 566.9 240.4Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 549.8438 247.5996)" class="abreviation-state">SE</text>
                </g>
                <g class="mapa-svg-estados state-rr-class" id="state-rr">
                    <path d="M325.1 113.8L326.2 125.5 313.8 125.5 312.7 126.5 310.7 130.4 309.8 133.5 310.7 135.3 308.5 136.8 306.1 137.1 304.1 133.9 302.2 133.2 298.3 134.8 297.5 136.2 297.3 139 296.6 141.6 296.8 143 293.9 142.6 292.3 140.2 289.2 138.1 287.1 136.2 289.3 134.4 288.6 131.4 287.3 130.2 286.3 127.8 287 126.9 286.5 125.3 287.3 122.1 286.8 120 287.8 119.3 286 112.9 284.1 110.7 284.9 109.5 285 107 281.3 106 280 104.5 277.7 103.9 277.7 101.9 272.9 101.9 270.6 101.4 271.1 98.7 268.7 94.3 268.5 91.2 269 89.6 267.6 87.9 265.4 86.5 264 85 264.8 83.6 267.2 83.3 269.6 83.7 270.4 85.9 272.5 85.5 275.2 85.6 276.8 86.4 278.8 85.8 281.9 89.2 284.1 89.2 284.6 87.7 284.1 86 284.6 84.6 286.6 84.5 288.5 83 290.5 83.9 293.6 83.3 295.4 82.2 297.3 82.3 297.9 80.6 303.6 79.2 304.4 77.4 305.9 76.8 307.5 75.2 307 72.3 310.5 72.1 311.8 71.3 314.3 73.2 313.5 79.6 316.1 80 317.5 80.8 316.9 82.8 319.1 85.4 317.5 88.1 315.8 89.1 315.9 91.6 314.5 95 314.1 99 315 102.4 316.8 103.6 316.8 106.8 318.7 109.4 322.2 113.1Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 294.1771 105.5996)" class="abreviation-state">RR</text>
                </g>
                <g class="mapa-svg-estados state-ap-class" id="state-ap">
                    <path d="M417.2 105.2L418.1 107 416.6 107.7 415.8 106.4ZM401 140.4L399.4 140.6 396.1 139.4 395.6 137.2 394.4 137.1 394.4 134.9 393.2 133.9 393.3 132.2 391.1 129.9 390.1 130 388.8 125.2 387.9 123.8 388.1 120.6 384.8 117.8 384.2 115.8 382.1 112.6 379.8 112.9 377.8 111.8 376.9 110.2 374.6 109 370.7 108.9 370.1 105.1 370.9 103.6 370.2 101.5 370.9 102.9 372.2 102.9 373.4 104.1 375.2 104.8 379.1 104.1 380.6 102.6 383.6 103.8 385.7 102.8 386.8 103.8 389.7 104.6 392.6 102.4 396.2 95.1 396.2 94.1 397.6 92.9 400.7 87.3 402.3 85.2 404 84.2 405.2 80.2 406.5 81.1 408.3 83.2 409.9 86.2 409.7 91.6 411 96.3 411.8 97.9 413.8 103.9 416 108 417.3 108.6 419.5 108.4 422.5 110.1 422.8 112.6 422.1 116.1 418.6 118.6 416.5 121 414.9 123.9 413 126.1 411.5 126.3 410 128.2 409 128.3 407.3 130.2 406 133 403.3 136 403.1 138.9Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 395.8438 114.5996)" class="abreviation-state">AP</text>
                </g>
                <g class="mapa-svg-estados state-ma-class" id="state-ma">
                    <path d="M509.1 157.6L509.4 159.7 507.3 162.7 505.5 164.5 502.4 165.3 500.3 167.4 499.5 170.1 496.8 173.3 497 174.9 498.1 176.3 497.2 179.3 497.7 179.9 498.8 183.4 498.5 185.1 495.6 188.6 495.9 193.1 498.3 195.2 498 198.5 496.5 200.8 491.8 201.6 489.4 200.1 485.4 200.9 482.8 204.3 481.1 204.9 478.9 206.8 476.2 208.1 472.2 209.2 470.1 210.6 469.2 213.7 469 215.8 467.3 218.9 467 220.6 465.2 222.7 464.6 224.2 465.5 228.6 466.5 229.5 465.9 235.9 465 237.7 465 239.4 463.5 238.2 460.7 237.7 459.4 236 459.2 234.5 457.2 233.1 458.7 231 456.4 229.5 455.4 226.9 452.9 224.9 454.7 223.2 454.5 222.2 455.5 219.2 456.7 218.6 459 218.5 459.2 213.7 458.2 213 455.1 213.7 453.5 214.6 450.6 210.5 448.4 208.1 448.2 206.3 446.9 205 448.2 203.4 448.9 198.3 449.7 195 449.1 193.6 449.3 191.1 448.5 189.7 448.2 187 443 184.2 441.3 184.5 439.3 183.5 437.3 183.9 435.2 185.5 435.1 185.4 445.1 177.3 446.7 177.5 449.6 173.9 450.6 171.8 453 169.2 453.4 166.3 454.3 164.4 455.7 163.6 457.3 161.2 457.3 157.3 459.9 154.9 459.6 153.3 461.4 150.9 462 149.1 462 146.4 462.9 141.2 463.5 140.9 466.9 141.5 467.4 140.1 470 143.3 471.3 143.7 471.4 146.5 473.4 143.9 475.7 144.1 478.3 147.4 480.3 147.8 480.6 151 482 152.7 480.5 153.9 479.2 157 478.5 160.1 479.2 160.7 481.6 159 482.7 154.6 485.3 153.7 485.6 154.7 484.4 156.6 488.7 154.9 491.9 155.3 491.6 153.1 493.3 153.2 499.8 155.4 501.9 157.2 504.6 157.6 504.9 158.2 507.9 158.5Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 465.1771 184.2663)" class="abreviation-state">MA</text>
                </g>
                <g class="mapa-svg-estados state-pi-class" id="state-pi">
                    <path d="M515.5 160.3L513.6 163.6 513.3 164.9 515.1 168.9 515.7 171.4 517.3 174.4 515.6 176.7 516.2 180.8 517.5 183.5 517.5 185.2 518.8 186.4 519.3 192.6 520.4 195.7 521.2 199.5 523.9 200.5 524.4 201.2 522.6 205.6 523.1 207.5 521.5 207.9 522.2 210.2 521.8 211.5 523.1 212.5 522.6 215.4 519 218.9 514.2 221.9 512.3 224.6 510.3 224.8 510.3 226.6 509.3 227.5 506.8 227.3 505.8 228.2 503.8 228.5 502.2 230.4 498.3 231 496.2 229.3 492.6 229.5 491.8 228.3 490.1 228.6 489.1 229.9 487.8 229.7 488.9 233.2 489.2 236 488.5 237.8 486.9 240 484.7 242.3 483.4 242.8 481.6 242.3 480 242.8 476.9 245.5 474.6 245.7 471.7 244.4 470.1 241.2 468.7 239.5 467 239.5 465 239.4 465 237.7 465.9 235.9 466.5 229.5 465.5 228.6 464.6 224.2 465.2 222.7 467 220.6 467.3 218.9 469 215.8 469.2 213.7 470.1 210.6 472.2 209.2 476.2 208.1 478.9 206.8 481.1 204.9 482.8 204.3 485.4 200.9 489.4 200.1 491.8 201.6 496.5 200.8 498 198.5 498.3 195.2 495.9 193.1 495.6 188.6 498.5 185.1 498.8 183.4 497.7 179.9 497.2 179.3 498.1 176.3 497 174.9 496.8 173.3 499.5 170.1 500.3 167.4 502.4 165.3 505.5 164.5 507.3 162.7 509.4 159.7 509.1 157.6 511.7 159.1 514.5 159.3Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 495.8438 215.5996)" class="abreviation-state">PI</text>
                </g>
                <g class="mapa-svg-estados state-ce-class" id="state-ce">
                    <path d="M558.5 179.9L555.3 181 553.3 182.5 551.3 186.7 549.9 188.3 549 191.2 547.2 193.3 545.8 193.1 544 195.6 544.7 196.6 542.3 202.8 543.2 205.1 544.7 206.6 542.9 210 541 211 540 212.5 537 210.7 536 209.3 532.6 207.3 530.5 207.1 528.2 207.7 523.1 207.5 522.6 205.6 524.4 201.2 523.9 200.5 521.2 199.5 520.4 195.7 519.3 192.6 518.8 186.4 517.5 185.2 517.5 183.5 516.2 180.8 515.6 176.7 517.3 174.4 515.7 171.4 515.1 168.9 513.3 164.9 513.6 163.6 515.5 160.3 515.2 158.8 518.8 158.7 523.7 158 529 158.5 531.8 160.4 535.8 162.2 538.8 164.2 540.1 164.7 543.2 167.4 545.5 167.9 546.2 169.3 547.7 170.5 550.1 173.5 552.8 175.2 554.6 177.5 557.6 178.4Z"
                          class="b" />
                    <text transform="matrix(1 0 0 1 527.8438 186.9329)" class="abreviation-state">CE</text>
                </g>
            </g>

        </svg>

        <div class="hist" style="border: 1px solid black;">
           
        </div>

    </div>

	<div id="home" class="tab-pane fade in active">
	<div id="tabOverview">
		<select id="anoAtual" class="form-control">
            <option value="2018">2018</option>
            <option value="2019" selected="selected">2019</option>
            <option value="2020">2020</option>
        </select>
	
    <div id="tabelaInfo" style="overflow-x:auto;">
        <table id="t01">
            <thead>
                <tr>
                    <th></th>
                    <th>JAN</th>
                    <th>FEV</th>
                    <th>MAR</th>
                    <th>ABR</th>
                    <th>MAI</th>
                    <th>JUN</th>
                    <th>JUL</th>
                    <th>AGO</th>
                    <th>SET</th>
                    <th>OUT</th>
                    <th>NOV</th>
                    <th>DEZ</th>
                    <th>RATE</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>AC</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>AL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>AP</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>AM</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>BA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>CE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>DF</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>ES</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>GO</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>MA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>MT</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>MS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>MG</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>PA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>PB</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>PR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>PE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>PI</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>RJ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>RN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>RS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>RO</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>RR</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>SC</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>SP</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>SE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>TO</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
   
    </div>
	</div>
	<div id="menu1" class="tab-pane fade">
		<div id="tabHistory"> fala</div>
	</div>
	</div>

	
		</div>
</div>
<!--

<div class="container-fluid">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
	<li><a data-toggle="tab" href="#menu4">Menu 4</a></li>
    <li><a data-toggle="tab" href="#menu5">Menu 5</a></li>
    <li><a data-toggle="tab" href="#menu6">Menu 6</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <button class="btn btn-primary" onclick="menu3()">go to menu 3</button>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
  
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
    
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
    </div>
	<div id="menu4" class="tab-pane fade">
      <h3>Menu 3</h3>
    </div>
	<div id="menu5" class="tab-pane fade">
      <h3>Menu 3</h3>
    </div>
	<div id="menu6" class="tab-pane fade">
      <h3>Menu 3</h3>
    </div>
	<div id="menu7" class="tab-pane fade">
      <h3>Menu 3</h3>
    </div>

  </div>
  
  
</div>
-->
