FROM node:22-slim

RUN apt-get update && apt-get install -y --no-install-recommends \
    python3 default-jre-headless \
    && npm install -g sass \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./data /project/data

WORKDIR /project/data/css_compress

USER 1000

ENTRYPOINT [ "python3", "/project/data/css_compress/compress.py", "/project/www/data/css/styles.scss", "/project/www/data/css/styles.css", "/project/www/data/css/styles.min.css" ]