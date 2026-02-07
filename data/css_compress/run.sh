#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/../.." && pwd)"

UUID=$(cat /proc/sys/kernel/random/uuid)
CONTAINER_NAME="mscom-css-run-${UUID}"
IMAGE_NAME="mscom-css-compile-${UUID}"

cleanup() {
    docker rm "$CONTAINER_NAME" 2>/dev/null || true
    docker image rm "$IMAGE_NAME" 2>/dev/null || true
}
trap cleanup EXIT

docker build -t "$IMAGE_NAME" -f "$PROJECT_DIR/css_compress.dockerfile" "$PROJECT_DIR"

rm -f "$PROJECT_DIR/www/data/css/styles.css" "$PROJECT_DIR/www/data/css/styles.min.css"

docker create --name "$CONTAINER_NAME" --stop-timeout 60 "$IMAGE_NAME"
timeout 60 docker start -a "$CONTAINER_NAME"

docker cp "$CONTAINER_NAME:/project/www/data/css/styles.css"     "$PROJECT_DIR/www/data/css/styles.css"
docker cp "$CONTAINER_NAME:/project/www/data/css/styles.min.css" "$PROJECT_DIR/www/data/css/styles.min.css"
