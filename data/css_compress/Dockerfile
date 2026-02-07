FROM node:22-slim

RUN apt-get update && apt-get install -y --no-install-recommends \
    python3 default-jre-headless \
    && npm install -g sass \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /project
