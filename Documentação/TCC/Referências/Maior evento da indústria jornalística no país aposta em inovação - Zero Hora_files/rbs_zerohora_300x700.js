var getTimestamp = function() {
 var date = new Date();
 return ('00' + date.getFullYear()).slice(-2) +
  ('00' + date.getMonth()).slice(-2) +
  ('00' + date.getDate()).slice(-2);
};
(function(d, s, c) {
 var f = d.createElement(s);
 f.src = (d.location.protocol == 'https:') ?
 c.replace('http:', 'https:').replace('//akfs', '//s-akfs') : c + '?r=' + getTimestamp();
 var e = d.getElementsByTagName(s)[0]; e.parentNode.insertBefore(f, e);
})(document, 'script', '//akfs.nspmotion.com/aep/tag/br/rbs_zerohora_300x700.cfg.js');