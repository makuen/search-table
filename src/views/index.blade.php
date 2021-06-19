<html>
<head>
    <meta charset="UTF-8" content="text/html">
    <title>Search-table</title>
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <style>
        /*table {
            border-collapse: collapse;
            border: 1px solid black;
            width: 90%;
            background: #CCC;
            color: #F00;
            text-align: left
        }

        td {
            background: #FFF
        }

        [v-cloak] {
            display: none
        }

        .loading {
            display: none
        }

        .loading[v-cloak] {
            display: block
        }*/

    </style>
</head>
<body>
<div id="app" class=“loading” v-cloak>

    <el-form :inline="true" :model="search">

        <el-form-item label="范围">
            <el-select v-model="search.range" placeholder="活动区域">
                <el-option label="全部" value="0"></el-option>
                <el-option label="表名" value="1"></el-option>
                <el-option label="列名" value="2"></el-option>
                <el-option label="说明" value="3"></el-option>
            </el-select>
        </el-form-item>

        <el-form-item label="搜索">
            <el-input v-model="search.content" placeholder="搜索" @keyup.enter.native="submit"></el-input>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="submit">查询</el-button>
        </el-form-item>

    </el-form>

    <el-divider></el-divider>
    <div>
        <span>找到：@{{ tables.length }}</span>
    </div>
    <el-divider></el-divider>

    <div v-for="table in tables">
        <div style="text-align: center;"><h2>@{{table.name}}</h2></div>
        <br>

        <el-table :data="table.columns" style="width: 90%">

            <el-table-column prop="Field" label="字段"></el-table-column>
            <el-table-column prop="Type" label="类型"></el-table-column>
            <el-table-column prop="Null" label="Null"></el-table-column>
            <el-table-column prop="Default" label="Default"></el-table-column>
            <el-table-column prop="Comment" label="说明"></el-table-column>

        </el-table>
        <br><br>
        <el-divider></el-divider>
    </div>
</div>
</body>
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    new Vue({
        el: "#app",
        data: {
            "tables":@json($res),
            "search": {
                "range": "0",
                "content": ""
            }
        },
        methods: {
            submit: function () {
                axios({
                    method: "post",
                    url: "/search-table",
                    data: this.search,
                    transformRequest: [function (data) {
                        let ret = '';
                        for (let i in data) {
                            ret += encodeURIComponent(i) + '=' + encodeURIComponent(data[i]) + "&";
                        }
                        return ret;
                    }],
                    header: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(resp => {
                    this.tables = resp.data.data;
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    })
</script>
</html>
