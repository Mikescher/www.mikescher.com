use crate::common::AdventOfCodeDay;

use std::u32;

#[derive(Debug)]
struct BoardingPass {
    row: u32,
    column: u32,
}

#[derive(Debug)]
pub struct Day05 {
    input: Vec<BoardingPass>,
}

impl BoardingPass {
    fn seat_id(&self) -> u32 { self.row * 8 + self.column }
}

fn parse_line(val: &str) -> BoardingPass {
    
    let sval = val.to_owned()
             .replace("F", "0")
             .replace("B", "1")
             .replace("R", "1")
             .replace("L", "0");

    BoardingPass {
        row:    u32::from_str_radix(&sval[0..7],  2).unwrap(),
        column: u32::from_str_radix(&sval[7..10], 2).unwrap(),
    }
} 

impl Day05 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/05_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .lines()
                        .map(parse_line)
                        .collect::<Vec<BoardingPass>>();

        Self {
            input: data
        }
    }
}

impl AdventOfCodeDay for Day05 {

    fn task_1(&self) -> String {
        verboseln!("{:?}", self.input);
        return self.input.iter().map(|p| p.seat_id()).max().unwrap().to_string()
    }

    fn task_2(&self) -> String  {
        let min = self.input.iter().map(|p| p.seat_id() as u64).min().unwrap();
        let sum = self.input.iter().map(|p| p.seat_id() as u64 - min).sum::<u64>(); // sum of all pass numbers 

        let allsum = (self.input.len() * (self.input.len() + 1) / 2) as u64; // sum if all pass numbers are there

        let missing = (allsum - sum) + min; // diff = the _one_ missing number

        return missing.to_string()
    }
}