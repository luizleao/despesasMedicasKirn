Vue.component('blog-post', {
	props: ['title'],
	template: `<h3>{{ title }}</h3>`
})

Vue.component('busca-pessoa', {
	props: ['title'],
	template: `<h3>{{ title }}</h3>`
})

Vue.component('loading', {
	template: `
			<div class="loader" id="loader">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>`
})
