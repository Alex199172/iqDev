
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width,initial-scale=1'/>
	<title>Депозитный калькулятор</title>
	<meta name="description" content="title" />
	<meta name="keywords" content="Депозитный калькулятор" />
	<link rel="stylesheet" href="assets/css/stylet.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
	<header class="header">
		<img class="header__logo" src="assets/img/logo.png" alt="logo" class="logo">
		<div class="header__title">
			Deposit Calculator
		</div>
	</header>
	<section class="main">
		<div class="main__margin">
			<div class="main__wrapper">
				<div class="main__info">
					<h1 class="main__title">
						Депозитный калькулятор
					</h1>
					<h2 class="main__subtitle">
						Калькулятор депозитов позволяет рассчитать ваши доходы
						после внесения суммы на счет в банке по опредленному тарифу.
					</h2>
				</div>
						<form class="main__calc" action="calc.php" method="POST" id="form">
							<div class="form__wrapper">
								<div class="form__margin">
									<input  class="date date__open" name="startDate" type="date" required>
									<div class="placholder">
										<label for="date__open">Дата откытия</label>
									</div>
								</div>
								<div class="form__margin">
									<div class="wrap__input">
											<input class="date__deposite" name="term" type="number" required id="exampleList2">
											<div class="placholder">
												<label for="date__deposite">Срок вклада</label>
											</div>
									</div>
										<select class="select__data" id="exampleList">
											<option class="mounth" value="term">месяц</option>
											<option class="year" value="term2">год</option>
										</select>
								</div>
								<div class="form__margin">
									<input class="date date__sum" name="sum" type="number" required>
									<div class="placholder">
										<label for="date__sum">Сумма вклада</label>
									</div>
								</div>
								<div class="form__margin">
									<input  class="date date__percent" name="percent"  type="number" required>
									<div class="placholder">
											<label for="date__percent">Процентная ставка, % годовых</label>
									</div>
								</div>
								<div class="form__margin wrap__checked">
									<div>
										<input class="date__check" name="check" type="checkbox" id="check_label">
									</div>
									<div>
										<label for="check_label">Ежемесячное пополнение вклада</label>
									</div>
								</div>
								<div class="form__margin">
									<input class="date date__block" name="sumAdd" type="number">
									<div class="placholder">
										<label class="date__block-label" for="date__block">Сумма пополнения вклада</label>
									</div>
								</div>
								<div>
									<button class="btn" type="submit" name="enter">Рассчитать</button>
								</div>
							</div>
								<hr>
						</form>
						<div class="sum">
							Сумма к выплате
						</div>
				 		<div>
							<p class="post__date">

							</p>
						</div>
			</div>
		</div>
	</section>
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.1/jquery.validate.min.js"></script>
	<script src="assets/js/main.js"></script>
    </body>
</html>
