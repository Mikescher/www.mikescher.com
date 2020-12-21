use crate::common::AdventOfCodeDay;

pub struct Day18 {
    input: Vec<String>,
}

impl Day18 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/18_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let lines = input_str
                        .lines()
                        .map(|p| String::from(p))
                        .collect::<Vec<String>>();

        Self {
            input: lines
        }
    }
}

impl Day18 {
    fn full_eval_lin(formula: String) -> i64 {
        return Self::eval_lin(&formula.chars().filter(|p| *p != ' ').collect(), 0).0;
    }

    fn eval_lin(formula: &Vec<char>, start_idx: usize) -> (i64, usize) {

        let mut curr: i64 = 0;

        let mut i = start_idx;
        loop {
            if i >= formula.len() || formula[i] == ')' {
                return (curr, i+1);
            }

            let mut op = '+';

            if i > start_idx {
                op = formula[i];
                i += 1;
            }

            let param: i64;
            if formula[i] == '(' {
                (param, i) = Self::eval_lin(formula, i+1);
            } else {
                param = formula[i].to_string().parse::<i64>().unwrap();
                i += 1;
            }

            match op {
                '+' => { curr += param; }
                '*' => { curr *= param; }
                _   => panic!()
            }
        }
    }
}

impl Day18 {
    // Shunting-yard Algorithm
    fn eval_advanced(formula: String) -> i64 {
        let mut operands: Vec<i64> = Vec::new();
        let mut operators: Vec<char> = Vec::new();

        for chr in formula.chars().filter(|p| *p != ' ') {
            if chr == '*' || chr == '+' {

                while !operators.is_empty() && chr <= *operators.last().unwrap() {
                    let a = operands.pop().unwrap();
                    let b = operands.pop().unwrap();
                    let op = operators.pop().unwrap();
                    
                    operands.push(match op {
                        '+' => a+b,
                        '*' => a*b,
                        _   => panic!(),
                    });
                }

                operators.push(chr);

            } else if chr == '(' {
                
                operators.push(chr);
                
            } else if chr >= '0' && chr <= '9' {
                
                operands.push(chr.to_string().parse().unwrap());
                
            } else if chr == ')' {

                while *operators.last().unwrap() != '(' {
                    let a = operands.pop().unwrap();
                    let b = operands.pop().unwrap();
                    let op = operators.pop().unwrap();
                    
                    operands.push(match op {
                        '+' => a+b,
                        '*' => a*b,
                        _   => panic!(),
                    });
                }
                operators.pop();

            } else {

                panic!();

            }
        }
        
        while !operators.is_empty() {
            let a = operands.pop().unwrap();
            let b = operands.pop().unwrap();
            let op = operators.pop().unwrap();
            
            operands.push(match op {
                '+' => a+b,
                '*' => a*b,
                _   => panic!(),
            });
        }

        return operands.pop().unwrap();
    }
}

impl AdventOfCodeDay for Day18 {

    fn task_1(&self) -> String {

        if is_verbose!() {
            for line in &self.input {
                verboseln!("{}   :=   {:?}", line, Day18::full_eval_lin(line.to_owned()));
            }
        }

        return self.input.iter().map(|p| Day18::full_eval_lin(p.to_owned())).sum::<i64>().to_string();

    }

    fn task_2(&self) -> String  {

        if is_verbose!() {
            for line in &self.input {
                verboseln!("{}   :=   {:?}", line, Day18::eval_advanced(line.to_owned()));
            }
        }

        return self.input.iter().map(|p| Day18::eval_advanced(p.to_owned())).sum::<i64>().to_string();

    }
}