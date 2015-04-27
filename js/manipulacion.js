var contador=0;
  function addRow(tableID) {

               var table = document.getElementById(tableID);
               var rowCount = table.rows.length;
               var row = table.insertRow(rowCount);
               var cell1 = row.insertCell(0);
               var element1 = document.createElement("input");
               element1.type = "text";
               element1.name = "t1"+contador;
               element1.id = "t1"+contador;
               cell1.appendChild(element1);
               var cell2 = row.insertCell(1);
               var element2 = document.createElement("input");
               element2.style="max-width: 80px "  ;
               element2.type = "text";
               element2.name = "t2"+contador;
               element2.id = "t2"+contador;
               cell2.appendChild(element2);
               var cell3 = row.insertCell(2);
               var element3 = document.createElement("input");
               element3.style="max-width: 80px "  ;
               element3.type = "text";
               element3.name = "t3"+contador;
               element3.id = "t3"+contador;
               cell3.appendChild(element3);
               var cell4 = row.insertCell(3);
               var element4 = document.createElement("input");
               element4.style="max-width: 80px "  ;
               element4.type = "checkbox";
               element4.name = "t4"+contador;
               element4.id = "t4"+contador;
               cell4.appendChild(element4);
                contador++;
          }



          function deleteRow(tableID) {

               try {

               var table = document.getElementById(tableID);
               var rowCount = table.rows.length;
               var nbc=rowCount-contador-1;
                for(var i=0; i<nbc; i++){
                  var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                        if(null != chkbox && false == chkbox.checked){
                            var descripsion=  document.getElementById("A1"+i).value;
                            var feini=document.getElementById("A2"+i).value;
                            var fefin=document.getElementById("A3"+i).value;
                                      var formData = new FormData();

                                     formData.append("grupoEmpresa", document.getElementById("ge").value );
                                     formData.append("descripsion",descripsion);
                                     formData.append("fechaini",feini);
                                     formData.append("fechafin",fefin);
                                     formData.append("idac",document.getElementById("A0"+i).value);
                                     alert("id"+document.getElementById("A0"+i).value);
                                     formData.append("operacion","update");
                                         var xhr = new XMLHttpRequest();
                                              xhr.open("POST", "add_actividades.php");
                                              xhr.send(formData);
                           // alert("1 "+descripsion+" 2 " +feini+" 3 "+fefin" 4 " );
                            /*if( descripsion == null )
                             { alert("a");}
                            else{

                              }*/



                        }



                }



               for(var i=1; i<rowCount; i++) {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    if(null != chkbox && true == chkbox.checked) {
                         table.deleteRow(i);
                         rowCount--;
                         i--;
                    }

               }


               }catch(e) {

                    alert(e);

               }

          }
