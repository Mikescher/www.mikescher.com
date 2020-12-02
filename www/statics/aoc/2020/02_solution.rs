use crate::common::AdventOfCodeDay;

use std::convert::TryInto;

#[derive(Debug)]
struct Data {
    num1: i32,
    num2: i32,

    character: char,
    
    password: String,
}

pub struct Day02 {
    input: Vec<Data>,
}

impl Day02 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/02_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);

        let lines = input_str
                        .lines()
                        .map(|p| p.split(" ").map(String::from).collect::<Vec<String>>())
                        .map(|p| Data 
                            {
                                 num1: p[0].split("-").nth(0).unwrap().parse::<i32>().unwrap(),
                                 num2: p[0].split("-").nth(1).unwrap().parse::<i32>().unwrap(),
                                 character: p[1].chars().nth(0).unwrap(),
                                 password: p[2].to_owned(),
                            })
                        .collect::<Vec<Data>>();

        Self {
            input: lines
        }
    }
}

impl AdventOfCodeDay for Day02 {

    fn task_1(&self) -> String {
        //for v in &self.input { println!("{:?}", v); }

        return self.input.iter().filter(|p| 
        {
            return (p.password.chars().filter(|c| *c == p.character).count() as i32) >= p.num1 &&
                   (p.password.chars().filter(|c| *c == p.character).count() as i32) <= p.num2;
        })
        .count()
        .to_string()
    }

    fn task_2(&self) -> String  {
        return self.input
            .iter()
            .filter(|p| 
            {
                let c1 = ((p.password.len() as i32) > p.num1-1) && p.password.chars().nth((p.num1 - 1).try_into().unwrap()).unwrap() == p.character;
                let c2 = ((p.password.len() as i32) > p.num2-1) && p.password.chars().nth((p.num2 - 1).try_into().unwrap()).unwrap() == p.character;
                return c1 ^ c2;
            })
            .count()
            .to_string()
    }
}