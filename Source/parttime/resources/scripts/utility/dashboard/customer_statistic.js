function statistic() {
        // Get input data
        var dataR = new Array();
        var question_id = '5549494fb3747795897063';
        // Send AJAX request
        $.ajax({
            url: "../ajaxserver/dashboard.php",
            type: 'POST',
            data: 'nam=2016',
            success: function (data, textStatus, jqXHR) {
                try {
                    // Process data
                    var json = jQuery.parseJSON(data);
                    if(json.result == "success") {
                        console.log("success");
                        // Set token items
                        if (json.items.length > 0) {
                            var numberofQuestion = 5;
                            var DataQuestion = new Array(numberofQuestion);
                            for (i=0;i<numberofQuestion;i++){
                                DataQuestion[i] = new Array();
                            }
                            var Question = [];
                            for (i = 0; i < json.items.length; i++) {
                                var d = json.items[i];
                                if (Question.indexOf(d.question)<=0) {
                                    Question.push(d.question);
                                }
                                qid = (Question.indexOf(d.question));
                                len = DataQuestion[qid].length
                                DataQuestion[qid].push(d);
                                console.log("processing" + d.question + d.answer + d.total + d.month + d.year);
                            }
                            console.log(Question);
                            for (i=0;i<numberofQuestion;i++){
                                for (j=0;j<DataQuestion[i].length;j++){
                                    console.log("Cau hoi " + i + " " + DataQuestion[i][j].total);
                                }
                            }
                        } else {
                            console.log("Không tìm thấy dữ liệu");
                        }

                    } else {
                        console.log('error' + errorThrown);
                    }
                    
                }
                catch(err) {
                    loading = false; 
                }
            },
            timeout: 15000,      // timeout (in miliseconds)
            error: function(qXHR, textStatus, errorThrown) {
                console.log('error' + errorThrown);
            }
        });
    return dataR;
}

