<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkContentListControl">
        <xsl:variable name="permalink" select="permalink"/>
        <xsl:variable name="fields" select="fields"/>
        
        <div class="bk-content-list-top">
            <a href="{$permalink}/add" class="button">
                <i class="fa fa-plus"/>Add
            </a>
            <div class="clear"/>
        </div>
        <div class="bk-content-list">
            <div class="item odd">
                <xsl:for-each select="$fields/item">
                    <div class="field">
                        <div class="inner">
                            <xsl:value-of select="title"/>
                        </div>
                    </div>
                </xsl:for-each>
            </div>
            <xsl:for-each select="list/item">
                <div class="item">
                    <xsl:if test="position() mod 2 = 0">
                        <xsl:attribute name="class">item odd</xsl:attribute>
                    </xsl:if>
                    <xsl:variable name="item" select="."/>
                    <xsl:for-each select="$fields/item">
                        <xsl:variable name="name" select="name"/>
                        <xsl:call-template name="Field">
                            <xsl:with-param name="field" select="."/>
                            <xsl:with-param name="value" select="$item/*[name()=$name]"/>
                        </xsl:call-template>
                    </xsl:for-each>
                    <div class="field">
                        <a href="{$permalink}/edit/{id}" class="button">
                            <i class="fa fa-edit"/>
                        </a>
                    </div>
                    <div class="clear"/>
                </div>
            </xsl:for-each>
        </div>
    </xsl:template>
    <xsl:include href="Field.xsl"/>
</xsl:stylesheet>
