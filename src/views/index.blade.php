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
        }*/

        .el-menu-vertical-demo:not(.el-menu--collapse) {
            width: 200px;
            min-height: 400px;
        }

        [v-cloak] {
            display: none
        }

        .loading {
            display: none
        }

        .loading[v-cloak] {
            display: block
        }

        .left {
            width: 30%;
            border-right: 1px solid gold;
            height: 980px;
            overflow: auto;
        }

        .right {
            width: 69%;
            height: 980px;
        }
    </style>
</head>
<body>
<div id="app" class=“loading” v-cloak>

    <div style="float:left; width:20%" class="left">
        <el-radio-group v-model="isCollapse" style="margin-bottom: 20px; width:100%">
        </el-radio-group>
        <el-menu default-active="0" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose"
                 :collapse="isCollapse" style="width:100%">

            <el-submenu :index="index+''" v-for="(table,index) in tables" style="width:100%">
                <template slot="title" style="width:100%">
                    <span slot="title" style="width:100%">@{{ table.name }}</span>
                </template>
                <el-menu-item-group>
                    <a :href="'#'+table.name" v-for="column in table.columns">
                        <el-menu-item>
                            @{{ column.Field }}
                        </el-menu-item>
                    </a>
                </el-menu-item-group>
            </el-submenu>
        </el-menu>
    </div>

    <div style="float: right; width: 78%" class="left">

        <div class="top" style="position: fixed; z-index: 999; width: 100%; background-color: #fff">
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

            <div>
                <span>找到：@{{ tables.length }}</span>
            </div>
            <el-divider></el-divider>
        </div>

        <div v-for="table in tables" style="margin-top:150px">
            <div style="text-align: center;"><h2 :id="table.name">@{{table.name}}</h2></div>
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
            },
            isCollapse: false
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
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
        }
    })
</script>
</html>
