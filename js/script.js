mainBlockAddBtn = document.getElementById('mainBlockAddBtn');

modalWindow = document.getElementById('modal-w');
mainBlockAddBtn.addEventListener('click', () => {
	setCookie("parent_id", "0", 0.5);
	modalWindow.style.display = 'flex';
});

blockAddBtns = document.querySelectorAll('div.block form input[type="button"]');
blockAddBtns.forEach((blockAddBtn) => {
	blockAddBtn.addEventListener("click", () => {
		let parentId = '0';
		let block = blockAddBtn.closest('.block');
		if(block.classList) {
			let classes = Array.from(block.classList);

			for (let cls of classes) {
				if (/^block-\d+$/.test(cls)) {
					parentId = cls.match(/^block-(\d+)$/);
				}
			}
		}
		setCookie("parent_id", parentId[1], 0.5);
		modalWindow.style.display = 'flex';
	});
});


function setCookie(name, value, hours) {
	let expires = "";
	if (hours) {
			let date = new Date();
			date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "") + expires + "; path=/";
}