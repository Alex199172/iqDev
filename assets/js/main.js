
// Обработка Select
document.getElementById('exampleList').addEventListener('change', (event) => {
document.getElementById('exampleList2').name = event.target.value
});

// Input пополнения вклада
let addInput = document.querySelector('#check_label')
let blockDate = document.querySelector('.date__block')
let blockLabel = document.querySelector('.date__block-label')

 addInput.addEventListener('click', () => {
   blockDate.classList.toggle('hiden__input')
   blockLabel.classList.toggle('hiden__input')
 });


// Валидация и отправка формы
$(".main__calc").validate({
	submitHandler: function(form) {
		let  startDate = document.querySelector('.date__open').value
			    sum = document.querySelector('.date__sum').value
			    percent = document.querySelector('.date__percent').value
			    sumAdd = document.querySelector('.date__block').value
			     if(document.querySelector('.date__block').value == '') {
			       sumAdd = '0'
			     }
			    term = document.querySelector('.date__deposite').value
			     if(document.getElementById('exampleList').value == 'term2') {
			       term = document.querySelector('.date__deposite').value*12;
			     }

			 let data = {
			   startDate,
			   term,
			   sum,
			   percent,
			   sumAdd
			 };

			 fetch('calc.php', {
			      method: "POST",
			      body:JSON.stringify(data),
			      headers: {
			     'Content-Type': 'application/json'
			     },
			 }).then(rs => {
			   rs.json().then(rs => {
					   document.querySelector('.post__date').innerHTML = 	'&#8381;' + '' + rs.sum;
			        if (rs) {
			          console.log("Результат получен")
			        } else {
			          console.log("Ошибка")
			        }
			     console.log('result', rs)
			   })

			 })
 	},
  rules: {

  sum: {
		max: 30000000,
		min: 1000,
    required: true,
		digits: true
    },

	 percent: {
		 max: 10,
		 min: 3,
     required: true,
 		 digits: true
	 },

	 sumAdd: {
		 max: 30000000,
		 min: 0,
     digits: true
	 },

   term: {
     max: 60,
     min: 1,
     digits: true
   },

   term2: {
     max: 5,
     min: 1,
     digits: true
   },

   startDate: {
     digits: false,
     date: true
   }

 },
 messages: {

      sum: {
        required: "Сумма вклада от 1000 до 3000000",
        min: "Минимальная сумма вклада 1000",
        max: "Максимальная сумма вклада 30000000"
    },
      percent: {
        required: "Процентная ставка, % от 3 до 10",
        min: "Минимальная процентная ставка 3",
        max: "Максимальная процентная ставка 10"
    },
      sumAdd: {
        required: "Сумма пополнения вклада от 0 до 3000000",
        min: "Минимальная сумма сумма пополнения 0",
        max: "Максимальная сумма пополнения 30000000"
    },
     term: {
       required: "Oт 1 до 60 месяцев",
       min: "Минимальный срок вклада 1 месяц",
       max: "Не более 60 месяцев"
  },
    term2: {
       required: "От 1 до 5 лет",
       min: "Минимальный срок вклада 1 год",
       max: "Не более 5 лет"
},
      startDate: {
        required: "Введите дату открытия вклада",
  },
}
});
