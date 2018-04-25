var data = JSON.parse(tyw_month_chart_data);

var width = 400;
	height = 150;
	barWidth = width / data.length;
	padding = 1;

	var MaxPosts = d3.max(data, function(d) {
		return d.posts;
	});

	var yScale = d3.scaleLinear()
		.domain([0, MaxPosts])
		.range([height, 0]);

	var month_chart_svg = d3.select('#tyw_month_chart')
		.attr('width', width)
		.attr('height', height);

	var month_chart_bar = month_chart_svg.selectAll('rect')
	.data(data)
	.enter()
	.append('rect')
	  .attr('height', function(d) {
		  return height - yScale(d.posts);
	  })
	  .attr('width', barWidth - padding )
	  .attr('x', function(d, i) {
		  return i * barWidth;
	  })
	  .attr('y', function(d) {
		  return yScale(d.posts);
	  });