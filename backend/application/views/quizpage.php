<script src="<?php echo base_url('assets/js/lib/angular.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/lib/ng-table.min.js')?>" type="text/javascript"></script>
<style>
.ng-table-pager{
    visibility: hidden;
}
</style>
<div class="container" ng-app="main" ng-controller="DemoCtrl">

	<div class="row">
		<div class="col-lg-7 pull left">
			<div class="form-group">
				<label class="control-label" for="name">Question:</label>
				<input type="text" id="quizQuestionText" class="col-lg-4 form-control" name="questions" value="" size="100" />
			</div>
			<label>Answers:</label>
			<div class="input-group quizAnswers">
				<span class="input-group-addon">
					<input type="checkbox" class="quizAnswer" name="check_list[]" value="value 1" />
				</span>
				<input type="text" class="quizAnswerText" name="text_value[]" class="form-control" size="60"/>
			</div>
			<div class="input-group quizAnswers">
				<span class="input-group-addon">
					<input type="checkbox" class="quizAnswer" name="check_list[]" value="value 2" />
				</span>
				<input type="text" class="quizAnswerText" name="text_value[]" class="form-control" size="60"/>
			</div>
			<div class="input-group quizAnswers">
				<span class="input-group-addon">
					<input type="checkbox" class="quizAnswer" name="check_list[]" value="value 3" />
				</span>
				<input type="text" class="quizAnswerText" name="text_value[]" class="form-control" size="60"/>
			</div>
			<div class="input-group quizAnswers">
				<span class="input-group-addon">
					<input type="checkbox" class="quizAnswer" name="check_list[]" value="value 4" />
				</span>
				<input type="text" class="quizAnswerText" name="text_value[]" class="form-control" size="60"/>
			</div>
			<button type="submit" ng-click="addMCQ()" class="btn btn-primary top-buffer">
				Add
			</button>
		</div>

		<div class="col-lg-5 pull-right">
			<!-- <table class="table table-bordered " id="quiztable">
				<thead>
					<tr>
						<th>#</th>
						<th>Question</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table> -->
			
<div >
    <table ng-table class="table">
    <tr ng-repeat="mcq in mcqs" ng-click="loadQA()">
        <td data-title="'#'">{{mcq.no}}</td>
        <td data-title="'Questions'">{{mcq.question}}</td>
    </tr>
    </table>
    <div class="form-group">
        <button class="btn btn-info glyphicon glyphicon-phone" ng-click="previewQuiz()" type="button" data-toggle="modal" data-target="#myModal">
          Preview
        </button>
        <button type="submit" ng-click="saveQA()" class="btn btn-primary glyphicon glyphicon-transfer">          
            Save Quiz Page</button>
</div>
</div>
		</div>
	</div>
</div>


</form>

<?php $this->load->view("common/pagepreview"); ?>

<script>
var app = angular.module('main', ['ngTable']).
controller('DemoCtrl', function($scope) {
    
    $scope.mcqs = [
        ];
    $scope.addMCQ=function(){
       
        var answers=[];
        $('.quizAnswers').each(function(){
            var temp={"answer":$(this).find('.quizAnswerText').val(),"status":$(this).find('.quizAnswer').is(":checked")};
            answers.push(temp);
        });
        $scope.mcqs.push({'question':$('#quizQuestionText').val(),
        'answers':answers,'no':$scope.mcqs.length
        });
        $scope.resetform();
    }
    $scope.loadQA=function(){
                console.info(this.mcq);
        var qa=this.mcq;
        $('#quizQuestionText').val(qa['question']);
        var i=0;
        $('.quizAnswers').each(function(){
            $(this).find('.quizAnswerText').val(qa['answer'][i]['answer']);
            $(this).find('.quizAnswer').attr("checked", qa['answer'][i]['status']);
            i++;
        });
    }
    
    $scope.resetform=function(){

        $('#quizQuestionText').val("");
        $('.quizAnswers').each(function(){
            $(this).find('.quizAnswerText').val("");
            $(this).find('.quizAnswer').attr("checked", false);
        });
    }
    $scope.previewQuiz=function(){
         window.qas=$scope.mcqs;
         previewPage('QUIZ_PAGE')
    }
    
    $scope.saveQA=function(){

        $.ajax({
            url: window.baseurl+"page/addQuizPage",
            data: "quiz="+JSON.stringify($scope.mcqs),
            method:"POST",
            contentType: 'application/x-www-form-urlencoded',
        }).done(function() {
           window.location=window.baseurl+"page/managepage#pageadded";
            $('.page_order_alert').removeClass('hidden');
        });
    }
})

</script>