namespace AdventOfCode2019_16_1
{
	const DAY     = 16;
	const PROBLEM = 1;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const message = input.trim().split("").map(p => parseInt(p));

		let step = message;

		for (let i=0; i < 100; i++) step = FFT(step);

		AdventOfCode.output(DAY, PROBLEM, step.slice(0, 8).map(p=>p.toString()).reduce((a,b)=>a+b));
	}

	function FFT(msg: number[])
	{
		let result = [];

		for (let i=0; i < msg.length; i++)
		{
			let sum = 0;
			let str = "";
			for (let i2=0; i2 < msg.length; i2++)
			{

				let factor = [0, 1, 0, -1][Math.floor(((i2+1) % ((i+1)*4)) / (i+1))];
				str += msg[i2]+"*"+factor+" + ";
				sum += (msg[i2]*factor);
			}
			str += " = " + sum;
			sum = Math.abs(sum) % 10;
			str += " = " + sum;
			result.push(sum);

			AdventOfCode.outputConsole(str);
		}

		AdventOfCode.outputConsole("[" + result.map(p=>p.toString()).reduce((a,b)=>a+","+b)+"]");

		return result;
	}
}
