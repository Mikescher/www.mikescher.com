use crate::common::AdventOfCodeDay;

use std::collections::HashMap;

#[derive(Debug)]
pub struct Day15 {
    input: Vec<u32>,
}

impl Day15 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/15_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .split(',')
                        .map(|p| p.parse::<u32>().unwrap())
                        .collect::<Vec<u32>>();

        Self {
            input: data
        }
    }
}

struct MemoryIterator {
    starters: Vec<u32>,
    position: usize,
    history: HashMap<u32, (usize, usize)>,

    last_number: u32,
}

impl MemoryIterator {
    pub fn new(initial: Vec<u32>) -> Self {
        MemoryIterator {
            starters: initial,
            position: 1,
            history: HashMap::new(),
            last_number: 0,
        }
    }
}

impl Iterator for MemoryIterator {
    type Item = u32;

    fn next(&mut self) -> Option<u32> {
        verboseln!();

        let curr_pos = self.position;
        self.position += 1;
        verboseln!("[::] Get @ index {} (last_number = {})", curr_pos, self.last_number);

        if curr_pos <= self.starters.len() {
            self.last_number = self.starters[curr_pos-1];
            
            verboseln!("  > history.insert({}, [{}, {}])", self.last_number, 0, curr_pos);
            self.history.insert(self.last_number, (0, curr_pos));

            verboseln!("Starter : {}", self.last_number);
            return Some(self.last_number);
        }

        let (prev_1, prev_2) = self.history.get(&self.last_number).unwrap().clone();

        if prev_1 == 0 {
            
            self.last_number = 0;

            if let Some((nprev_1, nprev_2)) = self.history.get_mut(&self.last_number) {
                verboseln!("  > history.insert({}, [{}, {}]) [in-mem]", self.last_number, nprev_2, curr_pos);
                *nprev_1 = *nprev_2;
                *nprev_2 = curr_pos;
            } else {
                verboseln!("  > history.insert({}, [{}, {}])", self.last_number, 0, curr_pos);
                self.history.insert(self.last_number, (0, curr_pos));
            }

            verboseln!("FirstTime : {}", self.last_number);
            return Some(self.last_number);

        } else {

            self.last_number = (prev_2 - prev_1) as u32;

            if let Some((nprev_1, nprev_2)) = self.history.get_mut(&self.last_number) {
                verboseln!("  > history.insert({}, [{}, {}]) [in-mem]", self.last_number, nprev_2, curr_pos);
                *nprev_1 = *nprev_2;
                *nprev_2 = curr_pos;
            } else {
                verboseln!("  > history.insert({}, [{}, {}])", self.last_number, 0, curr_pos);
                self.history.insert(self.last_number, (0, curr_pos));
            }
            
            verboseln!("Repeating : {} - {} = {}", prev_2, prev_1, self.last_number);
            return Some(self.last_number);
        }
    }
}

impl AdventOfCodeDay for Day15 {

    fn task_1(&self) -> String {
        verboseln!("{:?}", self);

        verboseln!("{:?}", MemoryIterator::new(self.input.clone()).skip(2018).take(5).collect::<Vec<u32>>());

        return MemoryIterator::new(self.input.clone()).skip(2019).next().unwrap().to_string();
    }

    fn task_2(&self) -> String  {
        return MemoryIterator::new(self.input.clone()).skip(30_000_000 - 1).next().unwrap().to_string();
    }
}