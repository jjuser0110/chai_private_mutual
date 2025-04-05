document.addEventListener('DOMContentLoaded',()=>{
	document.querySelectorAll('.game-category').forEach((x)=>{
		x.addEventListener('click',setGameList);
	});
})

// LIGHT UP SELECTED GAME CATEGORIES
function setGameList(){
	let element = this;

	// DO NOTHING IF THE CATEGORIES ALREADY SELETED
	if(element.classList.contains('active')){
		console.log('do nth');
		return;
	}

	// REMOVE ALL 'ACTIVE'
	clearGameList();

	// SET 'ACTIVE' TO CLICKED ELEMENT
	element.classList.add('active');
}

// CLEAR ALL ACTIVE GAME CATEGORIES
function clearGameList(){
	document.querySelectorAll('.game-category').forEach((x)=>{
		x.classList.remove('active');
	});
}

// CLOSE STICKY ELEMENT 
function closeSticky(){
	document.querySelector('.sticky-element').classList.add('hide');
}
