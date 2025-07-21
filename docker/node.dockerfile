FROM node:20

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

ENV PATH="/app/node_modules/.bin:$PATH"

CMD ["npm", "run", "dev"]
