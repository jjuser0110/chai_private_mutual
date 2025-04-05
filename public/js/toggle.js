document.addEventListener("DOMContentLoaded", ()=>{
	document.querySelectorAll(".toggle-option").forEach((x)=>{
		x.addEventListener('click', showToggleContent);
	})

	document.querySelectorAll(".toggle-group-default").forEach((x)=>{
		x.querySelector('.toggle-option').click();
	})
});

function showToggleContent(event){
	try{
		// ELMNT
		let elmnt = event.target;
		
        // TARGET 
		let target = elmnt.getAttribute('target');
		if(target == undefined){
			elmnt = elmnt.closest('.toggle-option');
			target= elmnt.getAttribute('target');
		}

		// PARENT
		let parent = elmnt.closest('.toggle-group');

		// REMOVE ALL TOGGLE ACTIVE STYE
		parent.querySelectorAll('.toggle-option').forEach((x)=>{
			x.classList.remove('active');
		});

		// ADD ACTIVE STYLE TO CLICKED ELEMENT
		elmnt.classList.add('active');

		// HIDE ALL TOGGLE CONTENT
		parent.querySelectorAll('.toggle-content').forEach((x)=>{
			x.style.display = 'none';
		});

		// SHOW THE SELECTED TARGET
		document.getElementById(target).style.display = 'block';
	}
	catch(e){
		console.log(e);
	}
}