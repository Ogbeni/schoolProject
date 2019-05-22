
	var data_js = JSON.parse(entr);
	var default_spec_text = "";
	var dept_details = {};
	var layed_out = -1;
	function update(arg) {
		if(!guest){
			//console.log(arg.classList[1]);
			var update_hidden = document.getElementById("update_hidden");
			update_hidden.innerHTML = "";
			var drop_button = document.querySelector("div#drop_button");
			var newNodeH = document.createElement("h3");
			var updateButton = document.createElement("button");
			var currentText ="";
			newNodeH.id = arg.id;
			var table ="";
			switch(layed_out){
				case 0:
					newNodeH.innerHTML = "Update Department";
					update_hidden.appendChild(newNodeH);
					table = "departments";
					switch(arg.classList[1].split(",")[0]){
						case 'dept_name':
							newNodeH = document.createElement("input");
							newNodeH.value = arg.innerHTML;
							newNodeH.id = 'dept_name';
							update_hidden.appendChild(newNodeH);
							break;
						case 'dept_profile':
							newNodeH = document.createElement("textarea");
							newNodeH.value = arg.innerHTML;
							newNodeH.id = 'dept_profile';
							update_hidden.appendChild(newNodeH);
							break;
					}
					break;
				case 1:
					newNodeH.innerHTML = "Update Specialization";
					update_hidden.appendChild(newNodeH);
					table = "specialization";
					switch(arg.classList[1].split(",")[0]){
						case 'spec_name':
							newNodeH = document.createElement("input");
							newNodeH.id = 'spec_name';
							newNodeH.value = arg.getElementsByTagName("i")[0].innerHTML;
							update_hidden.appendChild(newNodeH);
							break;
						case 'spec_start_date':
							newNodeH = document.createElement("input");
							newNodeH.type = "date";
							newNodeH.id = 'spec_start_date';
							newNodeH.value = arg.getElementsByTagName("i")[0].innerHTML;
							update_hidden.appendChild(newNodeH);
							break;
						case 'spec_profile':
							newNodeH = document.createElement("textarea");
							newNodeH.value = arg.innerHTML;
							newNodeH.id = 'spec_profile';
							update_hidden.appendChild(newNodeH);
							break;
					}
					break;
				default:	
			}
			updateButton.classList.add("col-12");
			drop_button.onclick = null
			drop_button.onclick = e=>{
				var dept_arr_index = arg.classList[1].split(",")[1]
				var spec_arr_index = arg.classList[1].split(",")[2]
				if(table != "departments"){
					spec_arr_index=data_js.dept[dept_arr_index].dept_spec[spec_arr_index].spec_id;
				}else{
					spec_arr_index = -1;
				}
				dept_arr_index=data_js.dept[dept_arr_index].dept_id;
				
				console.log(arg);
				if(confirm("Are you sure you to drop "+ arg.innerHTML+"?")){
					displayNotePane("Dropping... "+arg.innerHTML);
					if (window.XMLHttpRequest) {
				          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
				      } else {
				          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
				      }
				      request.onreadystatechange = function() {
				          if (request.readyState == 4 && request.status == 200) {
				              console.log(">>"+request.responseText);
				              if(request.responseText ==  'successfully'){
				              	update_hidden.style.display = "none";
				              	setTimeout(document.location.reload(), 1000);
				              }
				          }
				      }
				      request.open("GET", "./php_files/drop.php?dept_id="+dept_arr_index+"&spec_id="+spec_arr_index, true);
				      request.send();
				}

			}
			updateButton.onclick = function(e) {
				// console.log(e.target.previousElementSibling);
				var dept_arr_index = arg.classList[1].split(",")[1]
				var spec_arr_index = arg.classList[1].split(",")[2]
				if(table != "departments"){
					spec_arr_index=data_js.dept[dept_arr_index].dept_spec[spec_arr_index].spec_id;
				}else{
					spec_arr_index = null;
				}

				dept_arr_index=data_js.dept[dept_arr_index].dept_id;
				var all = true;
				var tranv = e.target.previousElementSibling;
				changed_detail = tranv.value.trim();
				if( (changed_detail.length < 1) || currentText == changed_detail ){
					all = all && false;
					tranv.focus();
					return;
				}
				if(all){
					var formData = new FormData();
					formData.append('updated_text', changed_detail);
					formData.append('dept', dept_arr_index);
					formData.append('col', tranv.id);
					if(spec_arr_index != null){
						formData.append('spec', spec_arr_index);
					}else{
						//spec_arr_index = null;
					}
					formData.append('table', table);
					if (window.XMLHttpRequest) {
				          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
				      } else {
				          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
				      }
				      request.onreadystatechange = function() {
				          if (request.readyState == 4 && request.status == 200) {
				              console.log(">>"+request.responseText);
				              if(request.responseText ==  'successfully'){
				              	update_hidden.style.display = "none";
				              	setTimeout(document.location.reload(), 1000);
				              }
				          }
				      }
				      request.open("POST", "./php_files/update_change.php", true);
				      request.send(formData);
				}
			}
			updateButton.innerHTML = "UPDATE";
			update_hidden.appendChild(updateButton);
			currentText = updateButton.previousElementSibling.value;
			update_hidden.style.display = "block";
			drop_button.style.display = "block";
		}
	}
	function layout_dept(t) {
		layed_out = 0;
		document.getElementById("spec_container_out").style.display = "block";
		console.log(t.id);
		var indx = t.id;
		var spec_container = document.getElementById("spec_container_out").firstElementChild;
		spec_container.innerHTML = data_js.dept[indx].dept_name;
		spec_container.classList.remove(spec_container.classList.item(1));
		spec_container.classList.add("dept_name,"+t.id);
		spec_container.nextElementSibling.style.display = "none";
		spec_container.nextElementSibling.nextElementSibling.innerHTML = data_js.dept[indx].dept_profile;
		spec_container.nextElementSibling.nextElementSibling.classList.remove(spec_container.nextElementSibling.nextElementSibling.classList.item(1));
		spec_container.nextElementSibling.nextElementSibling.classList.add("dept_profile,"+t.id);
	}
	function layout_spec(t) {
		layed_out = 1;
		document.getElementById("spec_container_out").style.display = "block";
		console.log(t.id);
		var indx = t.id.split(",");
		var spec_container = document.getElementById("spec_container_out").firstElementChild;
		spec_container.innerHTML = data_js.dept[indx[0]].dept_name + " : <i>"+ data_js.dept[indx[0]].dept_spec[indx[1]].spec_name+"</i>" ;
		spec_container.classList.remove(spec_container.classList.item(1));
		spec_container.classList.add("spec_name,"+t.id);
		spec_container.nextElementSibling.style.display = "block";
		spec_container.nextElementSibling.innerHTML = "Since : <i>"+ data_js.dept[indx[0]].dept_spec[indx[1]].spec_start_date+"</i>";
		spec_container.nextElementSibling.classList.remove(spec_container.nextElementSibling.classList.item(1))
		spec_container.nextElementSibling.classList.add("spec_start_date,"+t.id);
		spec_container.nextElementSibling.nextElementSibling.innerHTML = data_js.dept[indx[0]].dept_spec[indx[1]].spec_profile;
		spec_container.nextElementSibling.nextElementSibling.classList.remove(spec_container.nextElementSibling.nextElementSibling.classList.item(1))
		spec_container.nextElementSibling.nextElementSibling.classList.add("spec_profile,"+t.id);
	}
	document.getElementById("update_hidden").onclick = function(e){
		document.getElementById("update_hidden").style.display = "block";
		// console.log(e);
		e.cancelBubble = true;
	}
	if(!guest){
		var default_spec_text = document.getElementById("init_spec").innerHTML;
		document.getElementById("add_new_dept").onclick = function(e){
			document.getElementById("dept_container_hidden").style.display = "block";
			e.cancelBubble = true;
		};
		document.getElementById("dept_container_hidden").onclick = function(e){
			document.getElementById("dept_container_hidden").style.display = "block";
			e.cancelBubble = true;

		};
		document.getElementById("main_div").onclick = function(e){
			if(!guest){
				document.getElementById("update_hidden").style.display = "none";
				document.getElementById("dept_container_hidden").style.display = "none";
				document.querySelector("div#drop_button").style.display = "none";
				// console.log(e);
			}
		}
	}
	function defaultdept(a, b){
		var mdiv = document.createElement("div");
		mdiv.className = "col-6 "+b;
		mdiv.innerHTML=a;
		return mdiv;
	}
	function addSpec(e){
		var spec_container = e.parentNode;
		console.log(e);
		spec_container.appendChild(defaultdept(default_spec_text, "spec_item"));
		console.log(e.parentElement);
	}
	function addDepartment(tra){
		var all = true;
		var tranv = tra.parentNode.firstElementChild.nextElementSibling;
		dept_details.name = tranv.value.trim();
		dept_details.profile = tranv.nextElementSibling.value.trim();
		if(!dept_details.name.length > 0){
			all = all && false;
			tranv.focus();
			return;
		}
		if(!dept_details.profile.length > 0){
			all = all && false;
			tranv.nextElementSibling.focus();
			return;
		}
		var spec_d = tra.parentNode.getElementsByClassName("spec_item");
		var spec_item = [];
		for (var j = 0; j < spec_d.length; j++) {
			var spec_d_d = {};
			spec_d_d.name = spec_d[j].firstElementChild.value;
			spec_d_d.profile = spec_d[j].firstElementChild.nextElementSibling.value;
			spec_d_d.start_date = spec_d[j].lastElementChild.value;
			spec_item[j] = spec_d_d;
			if(!spec_d_d.name.length > 0){
				all = all && false;
				spec_d[j].firstElementChild.focus();
				return;
			}
			if(!spec_d_d.profile.length > 0){
				all = all && false;
				spec_d[j].firstElementChild.nextElementSibling.focus();
				return;
			}
			if(!spec_d_d.start_date > 0){
				all = all && false;
				spec_d[j].lastElementChild.focus();
				return;
			}
		}
		dept_details.spec = spec_item;
		if(all){
			displayNotePane("Adding "+dept_details.name, true);
			var formData = new FormData();
			formData.append('json_text', JSON.stringify(dept_details));
			if (window.XMLHttpRequest) {
		          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
		      } else {
		          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
		      }
		      request.onreadystatechange = function() {
		          if (request.readyState == 4 && request.status == 200) {
		              console.log(request.responseText);
		              displayNotePane(dept_details.name + "added", true);
		              setTimeout(document.location.reload(), 5000);
		          }
		      }
		      request.open("POST", "./php_files/add_new_dept.php", true);
		      request.send(formData);
		}
	}

	document.querySelector("div#dept_container").style.marginTop = document.querySelector("div.nav-bar").clientHeight+"px";
	function displayNotePane(message, ab=false){
		var note_pane = document.querySelector("div.note-pane");
		note_pane.style.marginTop = "5%";
		note_pane.innerHTML = message;
		if(ab){
			note_pane.style.backgroundColor = "green";
		}else{
			note_pane.style.backgroundColor = "#ff0060";
		}
		setTimeout(()=>{note_pane.style.marginTop = "-100%";}, 3000);
		document.body.scrollIntoView();
    }