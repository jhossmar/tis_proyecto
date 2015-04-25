$(document).ready(function() {
	//actividad 1
	var newsletter = $("#actividad_1");
	var inital = newsletter.is(":checked");
	var topics = $("#actividad_1_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	newsletter.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});

	//actividad 3
	var newsletter_3 = $("#actividad_3");
	var inital_3 = newsletter_3.is(":checked");
	var topics_3 = $("#actividad_3_topics")[inital_3 ? "removeClass" : "addClass"]("gray");
	var topicInputs_3 = topics_3.find("input").attr("disabled", !inital_3);
	newsletter_3.click(function() {
		topics_3[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs_3.attr("disabled", !this.checked);
	});

	//actividad 4
	var newsletter_4 = $("#actividad_4");
	var inital_4 = newsletter_4.is(":checked");
	var topics_4 = $("#actividad_4_topics")[inital_4 ? "removeClass" : "addClass"]("gray");
	var topicInputs_4 = topics_4.find("input").attr("disabled", !inital_4);
	newsletter_4.click(function() {
		topics_4[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs_4.attr("disabled", !this.checked);
	});
	//actividad 5
	var newsletter_5 = $("#actividad_5");
	var inital_5 = newsletter_5.is(":checked");
	var topics_5 = $("#actividad_5_topics")[inital_5 ? "removeClass" : "addClass"]("gray");
	var topicInputs_5 = topics_5.find("input").attr("disabled", !inital_5);
	newsletter_5.click(function() {
		topics_5[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs_5.attr("disabled", !this.checked);
	});

	//actividad 6
	var newsletter_6 = $("#actividad_6");
	var inital_6 = newsletter_6.is(":checked");
	var topics_6 = $("#actividad_6_topics")[inital_6 ? "removeClass" : "addClass"]("gray");
	var topicInputs_6 = topics_6.find("input").attr("disabled", !inital_6);
	newsletter_6.click(function() {
		topics_6[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs_6.attr("disabled", !this.checked);
	});

	//actividad 7
	var newsletter_7 = $("#actividad_7");
	var inital_7 = newsletter_7.is(":checked");
	var topics_7 = $("#actividad_7_topics")[inital_7 ? "removeClass" : "addClass"]("gray");
	var topicInputs_7 = topics_7.find("input").attr("disabled", !inital_7);
	newsletter_7.click(function() {
		topics_7[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs_7.attr("disabled", !this.checked);
	});

	var newsletter_10 = $("#actividad_10");
	var inital_10 = newsletter_10.is(":checked");
	var topics_10 = $("#actividad_10_topics")[inital_10 ? "addClass" : "removeClass"]("gray");
	var topicInputs_10 = topics_10.find("textarea").attr("disabled", inital_10);
	newsletter_10.click(function() {
		topics_10[this.checked ? "addClass" : "removeClass"]("gray");
		topicInputs_10.attr("disabled", this.checked);
	});
});