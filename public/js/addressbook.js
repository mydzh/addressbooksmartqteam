document.querySelectorAll("button.edit").forEach((bttn)=> {bttn.addEventListener("click", function(event){
    event.preventDefault();
    let id = event.target.dataset.id

    let rowDiv = document.getElementById("row" + id);
    console.log("rowDiv:", rowDiv);
    rowDiv.querySelectorAll("input").forEach(inputRow => {
        if(inputRow.name !== "id" + id) {
            inputRow.disabled = false;
        }
    });
    rowDiv.querySelector("div.edit").style.display = "none";
    rowDiv.querySelector("div.save").style.display = "block";
    });
  });
  document.querySelectorAll("a.sortlink").forEach((bttn)=> {bttn.addEventListener("click", function(event){
    event.preventDefault();
    let sort = event.target.dataset.sort;
    let order = event.target.dataset.order;
    let getsort = event.target.dataset.getsort;
    let getorder = event.target.dataset.getorder;
    if(getsort === sort) {
      order = getorder;
    }
    window.location.href = "/index?sort="+sort+"&order="+order;

    });
  });

  

  document.querySelectorAll("button.save").forEach((bttn)=> {bttn.addEventListener("click", function(event){
    event.preventDefault();
    let id = event.target.dataset.id
    let rowDiv = document.getElementById("row" + id);
    let lastname = document.getElementById("lastname" + id);
    let firstname = document.getElementById("firstname" + id);
    console.log("rowDiv:", rowDiv);

    fetch('/edit', {
        method: 'POST',
        body: JSON.stringify({
            id:id,
            lastname:lastname.value,
            firstname:firstname.value,
        }),
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
        }
        })
        .then(function(response){ 
        return response.json()})
        .then(function(data)
        {
          console.log(data)

        /* title=document.getElementById("title")
        body=document.getElementById("bd")
        title.innerHTML = data.title
        body.innerHTML = data.body  
        */
      }).catch(error => console.error('Error:', error)); 

    rowDiv.querySelectorAll("input").forEach(inputRow => {
        if(inputRow.name !== "id" + id) {
            inputRow.disabled = true;
        }
    });
    rowDiv.querySelector("div.edit").style.display = "block";
    rowDiv.querySelector("div.save").style.display = "none";
  });
  });

  
  document.querySelectorAll("button.del").forEach((bttn)=> {bttn.addEventListener("click", function(event){
    event.preventDefault();
    let id = event.target.dataset.id
    let rowDiv = document.getElementById("row" + id);
    let lastname = document.getElementById("lastname" + id);
    let firstname = document.getElementById("firstname" + id);

    fetch('/del', {
      method: 'POST',
      body: JSON.stringify({
          id:id,
          lastname:lastname.value,
          firstname:firstname.value,
      }),
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
      }
      })
      .then(function(response){ 
      return response.json()})
      .then(function(data)
      {console.log(data)
        window.location.reload();
      /* title=document.getElementById("title")
      body=document.getElementById("bd")
      title.innerHTML = data.title
      body.innerHTML = data.body  
      */
    }).catch(error => console.error('Error:', error)); 


  });
  });

  document.querySelectorAll("button.add").forEach((bttn)=> {bttn.addEventListener("click", function(event){
    event.preventDefault();

    let newRow = document.createElement("div");
    newRow.classList.add("row");
    newRow.id = "newrow";
    let newId = document.createElement("div");
    newId.classList.add("col-sm-3");
    let newIdInput = document.createElement("input");
    newIdInput.name="id";
    newIdInput.id="newId";
    newIdInput.disabled = true;
    let newFirstname = document.createElement("div");
    newFirstname.classList.add("col-sm-3");
    
    let newFirstnameInput = document.createElement("input");
    newFirstnameInput.name="firstname";
    newFirstnameInput.id = "newFirstname";

    let newLastname = document.createElement("div");
    newLastname.classList.add("col-sm-3");
    
    let newLastnameInput = document.createElement("input");
    newLastnameInput.id = "newLastname";

    let newSave = document.createElement("div");
    newSave.classList.add("col-sm-1");
    let save = document.createElement("div");
    save.classList.add("save");
    let saveButton = document.createElement("button");
    saveButton.id = "saveNewRowButton";
    saveButton.innerText = "save";
    let newCancel = document.createElement("div");
    newCancel.classList.add("col-sm-1");
    let cancel = document.createElement("div");
    cancel.classList.add("cancel");
    let cancelButton = document.createElement("button");
    cancelButton.id = "cancelButton";
    cancelButton.innerText = "cancel";

    newLastnameInput.name="lastname";
    newId.appendChild(newIdInput);
    newFirstname.appendChild(newFirstnameInput);
    newLastname.appendChild(newLastnameInput);
    
    save.appendChild(saveButton);
    newSave.appendChild(save);
    cancel.appendChild(cancelButton);
    newCancel.appendChild(cancel);

    newRow.appendChild(newId);
    newRow.appendChild(newFirstname);
    newRow.appendChild(newLastname);
    newRow.appendChild(newSave);
    newRow.appendChild(newCancel);

    let container = document.querySelector("#addressbookForm");
    container.appendChild(newRow);

    document.getElementById("addrow").style.display="none";

    document.getElementById("cancelButton").addEventListener("click", function(event){
      event.preventDefault();
      let newRow = document.getElementById("newrow");
   
      container.removeChild(newRow);
      document.getElementById("addrow").style.display="";
  });
  
  document.getElementById("saveNewRowButton").addEventListener("click", function(event){
    event.preventDefault();

    //let id = document.getElementById("newId");
    let lastname = document.getElementById("newLastname");
    let firstname = document.getElementById("newFirstname");


    fetch('/add', {
        method: 'POST',
        body: JSON.stringify({
            id:"",
            lastname:lastname.value,
            firstname:firstname.value,
        }),
        headers: {
          'Content-type': 'application/json; charset=UTF-8',
        }
        })
        .then(function(response){ 
        return response.json()})
        .then(function(data)
        {
          console.log(data);
          window.location.reload();
        /* title=document.getElementById("title")
        body=document.getElementById("bd")
        title.innerHTML = data.title
        body.innerHTML = data.body  
        */
      }).catch(error => console.error('Error:', error)); 

      //let newRow = document.getElementById("newrow");
 
      //container.removeChild(newRow);
      //document.getElementById("addrow").style.display="";
  

});
  });
  });

document.addEventListener("DOMContentLoaded", () => {
  let searchParams = new URLSearchParams(location.search);
  if(searchParams.has("load")){
    window.location.href = "/index";
  }
});
