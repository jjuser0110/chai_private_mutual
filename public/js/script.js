function setMenuActive(x){
	let parent = document.getElementById('navi-menu');
	parent.querySelector(`.${x}`).classList.add('active');
}


function onFocusInput(event) {
  	// Do something when the input field is in focus
	let parent = event.target.closest('.input-field');
	parent.classList.add('focus');
}

function onBlurInput(event) {
  	// Do something when the input field is in focus
	let parent = event.target.closest('.input-field');
	parent.classList.remove('focus');
}

document.addEventListener("DOMContentLoaded", ()=>{
	document.querySelectorAll('.inp-focus').forEach((x)=>{
		x.addEventListener('focus', onFocusInput);
		x.addEventListener('blur', onBlurInput);
	});

	document.querySelectorAll('.notice-toggle').forEach((x)=>{
		x.addEventListener('click', toggleNotice);
	});
	document.querySelectorAll('.popup').forEach((x)=>{
		x.addEventListener('click',(event)=>{
			if(event.target.classList.contains('popup')){
				x.classList.add('hide');
			}
		});
	});
});

function toggleNotice(event){
	console.log('click');
    let parent = event.target.closest('.notice-box');
    if(parent.classList.contains('minimize')){
        parent.classList.remove('minimize');
    }
    else{
        parent.classList.add('minimize');
    }
    console.log(parent);
}

function hidePopup(id){
	document.getElementById(id).closest('.popup').classList.add('hide');
}

function showPopup(id){
	document.getElementById(id).closest('.popup').classList.remove('hide');
}

function setDefaultSwal(icon, title, text){

    Swal.fire({
		icon: icon,
		title: title,
		text: text,
		customClass: {

			htmlContainer: 'cus-swal-html',

			confirmButton: 'cus-swal-confirm',

		  }
	})
}

/** SHOW TOGGLE GROUP **/
function showToggle(){
    // Get button attr 
    let target = this.getAttribute('target'),
    container = this.closest('.toggle-options');
    
    // Remove all selected style
    container.querySelectorAll('.toggle-option').forEach((x)=>{
        x.classList.remove('active');
    });
    
    try{
        // Hide all toggle-content
        let parent = this.closest('.toggle-group');
        parent.querySelectorAll('.toggle-content').forEach(function(element){
            element.classList.add('hide');
        });
        // Display the selected toggle group
        document.getElementById(target).classList.remove('hide');
    }
    catch(e){
        console.log(e);
    }
    
    // Add selected style to clicked button
    this.classList.add('active');
}

function startCountDown(element){
	var count = 120;
	element.disabled = true;
	element.classList.add('disabled');
	element.innerHTML = `${count}s`;
	var countdownInterval = setInterval(function() {
		count--;
		if (count <= 0) {
		clearInterval(countdownInterval);
		element.innerHTML = 'Send';
		element.classList.remove('disabled');
		element.addEventListener('click',(event)=>{startCountdown(event.target)});
		element.diabled = false;
		} else {
		element.innerHTML = `${count}s`;
		}
	}, 1000);
	element.onclick = null;
}

document.addEventListener('DOMContentLoaded',()=>{
	try{
		document.querySelectorAll('.toggle-option').forEach((e)=>{
			e.addEventListener('click', showToggle);
		});
	} catch(e){
		//do nth
	}

	// try{
	// 	document.querySelector('.btn-otp').addEventListener('click', (event)=>{
	// 		startCountDown(event.target);
	// 	});
	// } catch(e){
	// }

	try{
		document.querySelectorAll('.btn-copy').forEach((x)=>{
			x.addEventListener('click', async ()=>{
				const parent = x.closest('.copy-content');
				const value = parent.querySelector('.copy-value').textContent;
				try {
					await navigator.clipboard.writeText(value);
					x.innerHTML = "<p style='font-size:14px'>Copied</p>";
					setTimeout(() => {
						x.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
					</svg>`;
					}, 2000);
				} catch (err) {
					//console.error('Unable to copy: ', err);
				}
			});
			
		});
	} catch(e){
		//do nth
	}
});

function closeModal() {
    var modal = event.target.closest('.modal');
	modal.style.display = "none";
}