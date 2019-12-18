function createUserNote({ name, rating, cost, links, avatar }) {

	if ( !name | !rating | !cost | !avatar ) return null;

	const noteNode = document.createElement('li');

	noteNode.className = 'table-note';

	noteNode.onclick = event => {

		const socialsElement = document.querySelector('.profile-social');

		document.querySelector('.profile-avatar').src = avatar;
		
		socialsElement.innerHTML = '';
		links.map( data => {
			const element = document.createElement('a');
			element.href = data.link;
			element.textContent = data.name;
			socialsElement.appendChild(element);
		} );

		document.querySelector('.profile-login').textContent = 'Имя: ' + name;
		document.querySelector('.profile-rating').textContent = 'Рейтинг: ' + rating;
		document.querySelector('.profile-cost').textContent = 'Отправил: ' + cost;

		document.querySelector('.profile-dialog').classList.remove('disabled');

	};

	const userNameNode = document.createElement('div');
	const userRatingNode = document.createElement('div');
	const userCostNode = document.createElement('div');

	userNameNode.id = 'name';
	userRatingNode.id = 'rating';
	userCostNode.id = 'cost';

	userNameNode.textContent = name;
	userRatingNode.textContent = rating;
	userCostNode.textContent = cost;

	noteNode.appendChild( userNameNode );
	noteNode.appendChild( userRatingNode );
	noteNode.appendChild( userCostNode );

	return noteNode;

};

function createGroup({ notes }) {

	if ( !notes && notes.length == 0 ) return null;


	const groupNode = document.createElement('ul');
	groupNode.className = 'carousel-group fade';

	notes.map( note => {

		const noteNode = createUserNote(note);
		if (note) groupNode.appendChild(noteNode);

	} );

	return groupNode;

};

const render = ( nodeToRender, parent ) => parent.appendChild(nodeToRender); 

let ratingCounter = 0;
let sendedCount = faker.random.number()

const pseudoResponse = () => new Promise( ( resolve, reject ) => {

	resolve([
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		},
		{
			name: faker.name.findName(),
			rating: ++ratingCounter,
			cost: sendedCount - ratingCounter + '₽',
			links: [ { name: "VK", link: 'https://vk.com/qvinciy' } ],
			avatar: faker.image.avatar()
		}
	])

} );

let carouselIndex = 1;

pseudoResponse().then( group => {

	render(
		createGroup({ notes: group }),
		document.querySelector('.table-carousel')
	);

	showSlides(1)

} );

pseudoResponse().then( group => {

	render(
		createGroup({ notes: group }),
		document.querySelector('.table-carousel')
	);

} );


function showSlides(n) {

  const slides = document.querySelectorAll('.carousel-group');

  if ( n > slides.length ) carouselIndex = 1;
  if ( n < 1 ) carouselIndex = 1;

  [ ...slides ].map( slide => slide.classList.remove('enabled') );
  slides[ carouselIndex - 1 ].classList.add('enabled');

};

function nextSlide() {

	carouselIndex = carouselIndex + 1;
	showSlides(carouselIndex);

};

function prevSlide() {

	carouselIndex = carouselIndex - 1;
	showSlides(carouselIndex);

};

document.querySelector('#prevCarousel').onclick = () => prevSlide();
document.querySelector('#nextCarousel').onclick = () => {

	pseudoResponse().then( group => render(
		createGroup({ notes: group }),
		document.querySelector('.table-carousel')
	) );

	nextSlide();

};

document.querySelector('#showAccount').onclick = () => 
	document.querySelector('.auth-dialog').classList.remove('disabled');

[...document.querySelectorAll('.overlay')].map( overlay => overlay.onclick = e => {
	let dialogs = document.querySelectorAll('.modal-dialog');
	[...dialogs].map( dialog => dialog.classList.add('disabled') )
} );

document.querySelector('.profile-menu > header').onclick = function(e) {
	document.querySelector('.profile-dialog').classList.add('disabled');
};


