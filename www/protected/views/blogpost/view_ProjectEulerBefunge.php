<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
/* @var $problems EulerProblem[] */
/* @var $currproblemID int */
/* @var $currproblem EulerProblem */
?>

<?php

$this->pageTitle = 'Blogpost: ' . $model->Title . ' - ' . Yii::app()->name;

if ($currproblemID < 0)
{
	$this->breadcrumbs = array(
		'Blog' => ['/blog'],
		$model->Title,
	);
}
else
{
	$this->breadcrumbs = array(
		'Blog' => ['/blog'],
		$model->Title => [$model->getLink()],
		'Problem_' . str_pad($problems[$currproblemID]->Problemnumber, 3, '0', STR_PAD_LEFT),
	);
}


array_push($this->css_files, "/css/blogpost_ProjectEulerBefunge_style.css");

?>

<div class="container">

	<?php echo MsHtml::pageHeader("Blog", "My personal programming blog"); ?>

	<?php if ($currproblemID < 0): ?>
	<div class="blogOwner well markdownOwner" style="position: relative;">
		<a href="https://github.com/Mikescher/Project-Euler_Befunge"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>

		<h1><?php echo $model->Title ?></h1>

		<p><a href="https://projecteuler.net/problems"><img src="https://projecteuler.net/profile/Mikescher.png" /></a></p>

		<p>A lot of you probably know <a href="https://projecteuler.net/">Project Euler</a>.<br />
			For those who don't here a short explanation: Project Euler is a collection of mathematical/programming problems.
			Most problems consist of finding a single number and are solved by writing a program in the programming language of your choice.</p>
		<p>Most people solve these by using normal languages like C, Java, Phyton, Haskell etc.
			But you can also go a step further and try solving it with a little bit more exotic languages.</p>
		<p>So here are my solutions written in <a href="http://esolangs.org/wiki/Befunge">Befunge</a></p>
		<blockquote>
			<p><strong>Note:</strong><br />
				Similar to most Befunge content on this site I only used the Befunge-93 instruction-set but ignored the 80x25 size restriction.
				<em>(Even so most programs here don't get this big.)</em></p>
		</blockquote>

		<table class="PEB_tableProblems items table table-striped table-bordered table-condensed">
			<thead>
			<tr>
				<th>Number</th>
				<th>Title</th>
				<th>Time</th>
				<th>Size</th>
				<th>Solution (hover to reveal)</th>
			</tr>
			</thead>

			<tbody>
			<?php
			for($i = 0; $i < count($problems); $i++)
			{
				$problem = $problems[$i];

				echo '<tr class="PEB_tablerowProblems">' . "\r\n";

				echo '<td class="PEB_tablecellProblems PEB_TC_Number">' . $problem->Problemnumber . "</td>\r\n";
				echo '<td class="PEB_tablecellProblems PEB_TC_Title"><a href="' . $problems[$i]->getBlogLink() . '">' . $problem->Problemtitle . "</a></td>\r\n";
				echo '<td class="PEB_tablecellProblems"><div class="PEB_TC_Time PEB_TC_Timelevel_' . $problem->getTimeScore() . '">' . MsHelper::formatMilliseconds($problem->SolutionTime) . "</div></td>\r\n";

				if ($problem->isBefunge93())
					echo '<td class="PEB_tablecellProblems">' . $problem->SolutionWidth . 'x' . $problem->SolutionHeight . '<div class="PEB_TC_Size_93">Bef-93</div>' . "</td>\r\n";
				else
					echo '<td class="PEB_tablecellProblems">' . $problem->SolutionWidth . 'x' . $problem->SolutionHeight . '<div class="PEB_TC_Size_98">Bef-98</div>' . "</td>\r\n";

				echo '<td class="PEB_tablecellProblems PEB_TC_Value">' . number_format($problem->SolutionValue, 0, null, ',') . "</td>\r\n";

				echo "</tr>\r\n";
			}
			?>
			</tbody>
		</table>
	</div>
	<?php endif ?>

	<div class="blogOwner well markdownOwner" style="position: relative;">
		<?php
			if ($currproblemID >= 0)
			{
				echo '<a href="https://github.com/Mikescher/Project-Euler_Befunge"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>';

				echo "<h1>$model->Title</h1>";

				echo ParsedownHelper::parse($currproblem->generateMarkdown());
			}
			else
			{
				echo "<h2>Problems:</h2>";
			}
		?>

		<?php
		$pagination = array();

		for ($i = 0; $i < ceil(count($problems)/20)*20; $i++)
		{
			if ($i < count($problems))
				array_push($pagination,
					[
						'label' => str_pad($problems[$i]->Problemnumber, 3, '0', STR_PAD_LEFT),
						'url' => $problems[$i]->getBlogLink(),
						'disabled' => false,
						'active' => $currproblemID == $i,
					]);
			else
				array_push($pagination,
					[
						'label' => str_pad($i+1, 3, '0', STR_PAD_LEFT),
						'url' => '#',
						'disabled' => true,
						'active' => false,
					]);

			if ((($i+1) % 20 == 0))
			{
				echo TbHtml::pagination($pagination, ['align' => TbHtml::PAGINATION_ALIGN_CENTER]);
				$pagination = array();
			}
		}
		echo TbHtml::pagination($pagination, ['align' => TbHtml::PAGINATION_ALIGN_CENTER]);
		?>

		<div class="blogFooter">
			<div class="blogFooterLeft">
				<?php echo $model->Title; ?>
			</div>
			<div class="blogFooterRight">
				<?php echo $model->getDateTime()->format('d.m.Y'); ?>
			</div>
		</div>
	</div>

	<div class="disqus_owner">
		<?php
		$this->widget(
			'ext.YiiDisqusWidget.YiiDisqusWidget',
			[
				'shortname' => 'mikescher-de',
				'identifier' => 'blog/view/' + $model->ID,
				'title' => $model->Title,
				'url' => $model->getAbsoluteLink(),
				'category_id' => '3253401', // = blog/view
			]
		);
		?>
	</div>

</div>
