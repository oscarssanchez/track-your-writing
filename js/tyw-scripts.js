var data = JSON.parse(tyw_month_chart_data);

var width = 600;
height = 150;
barWidth = 20;

var MaxPosts = d3.max(data, function (d) {return d.posts } );

var yScale = d3.scaleLinear()
	.domain([0, MaxPosts])
	.range([height, 0]);


var month_post_chart = d3.select("#tyw_month_chart")
	.attr("width", width)
	.attr("height", height );

var month_post_chart_bar =  month_post_chart.selectAll("g")
	.data(data)
	.enter()
	.append("g")
	.attr("transform", function(d, i) {
		return "translate(" + i * barWidth + ",0)"
	});

month_post_chart_bar.append("rect")
	.attr("width", barWidth )
	.attr("height", function(d) {
		return height - yScale(d.posts)  ;
	})
	.attr("x", function (d, i) {
		return ( barWidth + 5) *i;
	})
	.attr("y", function(d) { return yScale(d.posts) } )
	.attr("fill", "green");



