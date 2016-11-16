var AkrBanners = Class.create();
AkrBanners.prototype = {
	banners: false, // array of DIV's (which have the banners, should be all display:none stacked one on top of the other)
	timer: 5000,
	currentBanner: -1,
	playing: true, // use selectBanner to show one banner. Will stop rotating for 60s
	initialize: function(banners,timer) {
		this.banners = banners;
		this.timer = timer;
		this.showBanner(); // show first banner
	},
	showBanner: function() {
		if (this.banners.length ==0) return;
		if (this.currentBanner != -1)
			new Effect.Fade(this.banners[this.currentBanner]);
		this.currentBanner++;
		if (this.currentBanner >= this.banners.length) this.currentBanner = 0;
		if (this.banners.length == 1)
			$(this.banners[this.currentBanner]).style.display = '';
		else
			new Effect.Appear(this.banners[this.currentBanner]);
		if (this.playing && this.banners.length>1 ) setTimeout(this.showBanner.bind(this),this.timer);
	},
	selectBanner: function(which) {
		this.playing = false;
		if (this.currentBanner == which) return;
		if (this.currentBanner != -1)
			new Effect.Fade(this.banners[this.currentBanner]);
		this.currentBanner = which;
		new Effect.Appear(this.banners[this.currentBanner]);
		setTimeout(this.restartRotation.bind(this),60000);
	},
	restartRotation: function() {
		this.showBanner();
	}
}